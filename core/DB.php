<?php
//namespace Core;
//use Core\Model\BaseModel;

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/23
 * Time: 8:53
 */
class DB
{
    public static $TAG = "DB:";

    /**1
     * protected 用于之后继承
     * @var PDO
     */
    protected $pdo;

    // 用于在prepare时连接数据库
    protected $dsn;
    protected $charset;
    protected $name;
    protected $password;

    /**
     * @var PDOStatement
     */
    protected $pdoStatement = null;
    protected $fetchMode = null;
    protected $fetchClass = null;
    protected $pdoKeysAndValues = null;
    protected $pdoWhereKeysAndValues = null;

    public function __construct($dbConfigName)
    {
        if (array_key_exists($dbConfigName, $GLOBALS['config']['database'])) {
            $dbConfigs = $GLOBALS['config']['database'][$dbConfigName];
            // 这里的charset只在php5.3之后生效，之前的版本需要使用exec命令手动设置
            $this->dsn = "{$dbConfigs['db']}:host={$dbConfigs['host']};charset={$dbConfigs['charset']};
            dbname={$dbConfigs['dbname']}";
            $this->charset = $dbConfigs['charset'];
            $this->name = $dbConfigs['name'];
            $this->password = $dbConfigs['password'];
//            $this->pdo = new PDO(, $dbConfigs['name'], $dbConfigs['password']);
        } else {
            echo "not fonund this db config: $dbConfigName";
        }
    }

    public function getPOD()
    {
        return $this->pdo;
    }

    public function getStatement()
    {
        return $this->pdoStatement;
    }

    /**
     * 设置POD连接的参数
     */
    private function setParameters()
    {
        $this->pdo->exec("SET names {$this->charset}");
    }

    /**
     * 在这里进行连接数据库
     * @param null $sql
     * @param null $keyAndValues
     * @param null $whereKeyAndValues
     * @return $this
     */
    public function prepare($sql = null, $keyAndValues = null, $whereKeyAndValues = null)
    {
        $this->pdo = new PDO($this->dsn, $this->name, $this->password);
        $this->setParameters();

        try {
            // If sql is empty, use query string
            if ($sql == null) {
                $sql = $this->queryStr;
            }
            $this->pdoStatement = $this->pdo->prepare($sql);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        // Set fetch mode
        if ($this->fetchMode != null) {
            if ($this->fetchClass != null) {
                $this->pdoStatement->setFetchMode($this->fetchMode, $this->fetchClass);
            } else {
                $this->pdoStatement->setFetchMode($this->fetchMode);
            }
        }

        if ($keyAndValues != null) {
            $this->pdoKeysAndValues = $keyAndValues;
        }
        if ($whereKeyAndValues != null) {
            $this->pdoWhereKeysAndValues = $whereKeyAndValues;
        }

        $this->doBindValue();

        return $this;
    }

    private function doBindValue()
    {
        if ($this->pdoKeysAndValues != null) {
            // bind everything
            foreach ($this->pdoKeysAndValues as $key => $value) {
                $keyOK = $this->replaceDots($key);
                $this->pdoStatement->bindValue(':'.$keyOK, $value);
            }
        }

        if ($this->pdoWhereKeysAndValues != null) {
            // bind everything
            foreach ($this->pdoWhereKeysAndValues as $key => $value) {
                $keyOK = $this->replaceDots($key);
                $this->pdoStatement->bindValue(':'.$keyOK, $value);
            }
        }

    }

    public function bindValue($keyAndValue)
    {
        $this->pdoKeysAndValues = $keyAndValue;
        $this->doBindValue();
    }

    public function setFetchMode($fetchMode, $fetchClass = null)
    {
        $this->fetchMode = $fetchMode;
        $this->fetchClass = $fetchClass;
//        $this->pdoStatement->setFetchMode($fetchMode);
        return $this;
    }

    public function execute($keyAndValues = null)
    {
        // if keyAndValue is not blank, bind it
        if ($keyAndValues != null) {
            $this->pdoKeysAndValues = $keyAndValues;
        }
        $this->doBindValue();

        if(!$this->pdoStatement->execute()){
            throw new Exception('PDO执行出错：'. $this->queryStr);
        }

        // 清空sql
        $this->queryStr = '';

        return $this;
    }

    public function fetch()
    {
        return $this->pdoStatement->fetch();
    }

    public function fetchAll()
    {
        return $this->pdoStatement->fetchAll();
    }


    public function queryAll(BaseModel $model)
    {
        $this->prepare("select * from {$model->getTableName()}")->execute();
        return $this->fetchAll();
    }

    public function insert(BaseModel $model, $keyAndValues)
    {
        $columns = array_keys($keyAndValues);
        $columnsString = implode(',', $columns);
        $placeHolderString = ':' . implode(', :', $this->replaceDots($columns));
        $this->pdoKeysAndValues = $keyAndValues;
        // ues refer
        // use foreach for better performance
//        array_walk($placeHolderString, function (&$value, $key){
//            $value = ":{$value}";
//        });

//        $valuesString = implode(',', $values);

        // columns -> values to columns => values
//        for ($i = 0; $i < count($columns); $i++){
//            $this->pdoKeysAndValues[$columns[$i]] = $values[$i];
//        }

        return $this->prepare("insert into {$model->getTableName()} ({$columnsString}) values 
        ({$placeHolderString})")->execute();
    }

    public function update(BaseModel $model, $keyAndValues, $whereKeyAndValues)
    {
//        $columns = array_keys($keyAndValues);
//        $columnsString = implode(',', $columns);
//        $placeHolderString = ':' . implode(', :', $columns);
        $this->pdoKeysAndValues = $keyAndValues;
        $this->pdoWhereKeysAndValues = $whereKeyAndValues;

        $setStr = '';
        $index = 0;
        foreach (array_keys($keyAndValues) as $key) {
            if($index != 0){
                $setStr = $setStr . ', ';
            }
            $keyOK = $this->replaceDots($key);
            $setStr = $setStr . "{$key}=:{$keyOK}";

            $index ++;
        }

        $whereStr = '';
        $index = 0;
        foreach (array_keys($whereKeyAndValues) as $key) {
            if($index != 0){
                $whereStr = $whereStr . ', ';
            }
            $keyOK = $this->replaceDots($key);
            $whereStr = $whereStr . "{$key}=:{$keyOK}";

            $index ++;
        }
        // ues refer
        // use foreach for better performance
//        array_walk($placeHolderString, function (&$value, $key){
//            $value = ":{$value}";
//        });

//        $valuesString = implode(',', $values);

        // columns -> values to columns => values
//        for ($i = 0; $i < count($columns); $i++){
//            $this->pdoKeysAndValues[$columns[$i]] = $values[$i];
//        }

        // UPDATE table set xxxx
        return $this->prepare("update {$model->getTableName()} set {$setStr} where ({$whereStr})")->execute();
    }

    /**
     * 查询快捷方法
     * @param $model BaseModel
     * @param $whereKeyAndValues
     *          Only support AND condition
     * @return array
     */
    public function query($model, $whereKeyAndValues)
    {
        // set value
        $this->pdoWhereKeysAndValues = $whereKeyAndValues;

        $whereStr = '';
        $index = 0;
        foreach (array_keys($whereKeyAndValues) as $key) {
            if($index != 0){
                $whereStr = $whereStr . ' AND ';
            }
            $keyOK = $this->replaceDots($key);
            $whereStr = $whereStr . "{$key}=:{$keyOK}";

            $index ++;
        }

        $this->prepare("select * from {$model->getTableName()} where ({$whereStr})")->execute();

        return $this->pdoStatement->fetchAll();
    }

    // TODO: make this one to soft delete
    public function delete(BaseModel $model, $whereKeyAndValues)
    {
        // set value
        $this->pdoWhereKeysAndValues = $whereKeyAndValues;

        $whereStr = '';
        $index = 0;
        foreach (array_keys($whereKeyAndValues) as $key) {
            if($index != 0){
                $whereStr = $whereStr . ' AND ';
            }
            $keyOK = $this->replaceDots($key);
            $whereStr = $whereStr . "{$key}=:{$keyOK}";

            $index ++;
        }

        return $this->prepare("delete from {$model->getTableName()} where ({$whereStr})")->execute();
//
//         $this->pdoStatement->fetchAll();
    }

    private $queryStr;

    /**
     * TODO: 通过的builder构建
     * 现在暂时只考虑具有外链关联的两张表的自动关联
     * @param $selectedColumns
     * @param $model BaseModel
     */
    public function queryBuilder($selectedColumns, $model)
    {
        $selectedColStr = '';
        // 如果数组中只有一个元素，不进行implode
        if (count($selectedColumns) != 1) {
            $selectedColStr = implode(', ', $selectedColumns);
        } else {
            $selectedColStr = $selectedColumns[0];
        }

//        $tableStrArray = array();
//        foreach ($models as $key => $model){
//            $tableStrArray[$key] = $model->getTableName();
//        }
//        $tableStr = implode(', ', $tableStrArray);

        $this->queryStr = "select {$selectedColStr} from {$model->getTableName()}";
        return $this;
    }

    /**
     * queryBuilder
     * @param $model BaseModel
     */
    public function join($model)
    {
        $this->queryStr .= " left join {$model->getTableName()}";
        return $this;
    }

    /**
     * queryBuilder
     * @param $model BaseModel
     */
    public function rightJoin($model)
    {
        $this->queryStr .= " right join {$model->getTableName()}";
        return $this;
    }

    /**
     * @param $modelLeft BaseModel
     * @param $columnLeft
     * @param $modelRight BaseModel
     * @param $columnRight
     * @return $this
     */
    public function on($modelLeft, $columnLeft, $modelRight, $columnRight)
    {
//        $onStr = '';
        /*for ($i = 0; $i < count($models); $i++) {
            $onStr = "{$models[$i]->getTableName()}.{$columns[$i]}";
            if ($i%2 == 0) {
                $onStr .= '=';
            }
        }*/

        $this->queryStr .= " on {$modelLeft->getTableName()}.$columnLeft={$modelRight->getTableName()}.$columnRight";
        return $this;
    }

    /**
     * queryBuilder
     * @param $whereKeyAndValues
     * @param array $operations
     * @return $this
     */
    public function where($whereKeyAndValues, $operations = array('='))
    {
        // set value
        $this->pdoWhereKeysAndValues = $whereKeyAndValues;

        $whereStrArray = array();
        /*$index = 0;
        foreach (array_keys($whereKeyAndValues) as $key) {
            if($index != 0){
                $whereStr = $whereStr . ', ';
            }
            $whereStr = $whereStr . "{$key}=:{$key}";

            $index ++;
        }*/
        $keys = array_keys($whereKeyAndValues);

        $isDefaultOperation = false;
//        $operation = '';
        if (count($operations) == 1 && $operations[0] == '=') {
            $isDefaultOperation = true;
        }
        for ($i = 0; $i < count($whereKeyAndValues); $i++) {
            if ($isDefaultOperation) {
                $operation = '=';
            } else {
                $operation = $operations[$i];
            }
            // 替换占位符中的.为_
            $keyOK = $this->replaceDots($keys[$i]);
            $whereStrArray[$i] = "{$keys[$i]}{$operation}:{$keyOK}";
        }

        $whereStr = implode(', ', $whereStrArray);

        $this->queryStr .= " where {$whereStr}";

        return $this;
    }

    private function replaceDots($key)
    {
        return str_replace('.', '_', $key);
    }

    /**
     * queryBuilder
     * @param $orderColumns
     * @param $descOrAsc
     * @return $this
     */
    public function orderBy($orderColumns, $descOrAsc)
    {
        $orderStrArray = array();
        for ($i = 0; $i < count($orderColumns); $i++) {
            $orderStrArray[$i] = "$orderColumns[$i] $descOrAsc[$i]";
        }
//        $orderStr = ' order by ' . implode(', ', $orderStrArray);
        $this->queryStr .= ' order by ' . implode(', ', $orderStrArray);
        return $this;
    }

    /**
     * 第一个参数是count
     * queryBuilder
     * @param $count
     * @param int $offset
     */
    public function limit($count, $offset = 0)
    {
        $this->queryStr .= " limit {$offset}, {$count}";
        return $this;
    }
}