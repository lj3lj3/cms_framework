<?php
//namespace Core;
//use Core\Model\BaseModel;
//require_once dirname(__FILE__) . "/Log/Log.php";

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/23
 * Time: 8:53
 */
class DB
{
    const TAG = "DB";

    /**1
     * protected 用于之后继承
     * @var PDO
     */
    protected $pdo;

    private $queryStr = null;

    // 用于在prepare时连接数据库
    protected $dsn;
    protected $charset;
    protected $name;
    protected $password;

    public $tablePrefix;

    /**
     * @var PDOStatement
     */
    protected $pdoStatement = null;
    protected $fetchMode = null;
    protected $fetchClass = null;
    protected $pdoKeysAndValues = null;
    protected $pdoWhereKeysAndValues = null;

    protected $result;

    public function __construct($dbConfigName = 'mysql')
    {
        if (array_key_exists($dbConfigName, $GLOBALS['config']['database'])) {
            $this->tablePrefix = $GLOBALS['config']['database']['tablePrefix'];
            $dbConfigs = $GLOBALS['config']['database'][$dbConfigName];
            // 这里的charset只在php5.3之后生效，之前的版本需要使用exec命令手动设置
            $this->dsn = "{$dbConfigs['db']}:host={$dbConfigs['host']};charset={$dbConfigs['charset']};
            dbname={$dbConfigs['dbname']}";
            $this->charset = $dbConfigs['charset'];
            $this->name = $dbConfigs['name'];
            $this->password = $dbConfigs['password'];
//            $this->pdo = new PDO(, $dbConfigs['name'], $dbConfigs['password']);
            $this->pdo = new PDO($this->dsn, $this->name, $this->password);
            $this->setParameters();
        } else {
            echo "not fonund this db config: $dbConfigName";
        }
    }

    public static function getTablePrefix()
    {
        return $GLOBALS['config']['database']['tablePrefix'];
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
        $timeBefore = 0;
        if ($GLOBALS['config']['debug'] == true) {
            $timeBefore = microtime(true);
        }
        try {
            // If sql is empty, use query string
            if ($sql == null) {
                $sql = $this->queryStr;
            } else if ($this->queryStr == null) {
                // If sql is not null, but queryStr is null, set it back
                $this->queryStr = $sql;
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

        if ($keyAndValues != null && $keyAndValues != '') {
            $this->pdoKeysAndValues = $keyAndValues;
        }

        if ($whereKeyAndValues != null && $whereKeyAndValues != '') {
            $this->pdoWhereKeysAndValues = $whereKeyAndValues;
        }

        $this->doBindValue();

        if ($GLOBALS['config']['debug'] == true) {
            $timeUsed = microtime(true) - $timeBefore;
            Log::debug(DB::TAG, "Prepare time used: $timeUsed");
        }

        return $this;
    }

    private function doBindValue()
    {
        if ($this->pdoKeysAndValues != null && $this->pdoKeysAndValues != '') {
            // bind everything
            foreach ($this->pdoKeysAndValues as $key => $value) {
                $keyOK = $this->replaceDots($key);
                $this->pdoStatement->bindValue(':' . $keyOK, $value);
            }
        }

        if ($this->pdoWhereKeysAndValues != null && $this->pdoWhereKeysAndValues != '') {
            // bind everything
            foreach ($this->pdoWhereKeysAndValues as $key => $value) {
                $keyOK = $this->replaceDots($key);
                $this->pdoStatement->bindValue(':' . $keyOK, $value);
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
        $timeBefore = 0;
        if ($GLOBALS['config']['debug'] == true) {
            $timeBefore = microtime(true);
        }
        // if keyAndValue is not blank, bind it
        if ($keyAndValues != null) {
            $this->pdoKeysAndValues = $keyAndValues;
        }
        $this->doBindValue();
        $this->result = $this->pdoStatement->execute();
        if (!$this->result) {
            throw new Exception('PDO执行出错：' . $this->queryStr);
        }

        if ($GLOBALS['config']['debug'] == true) {
            $timeUsed = microtime(true) - $timeBefore;
            Log::debug(DB::TAG, "Execute: $this->queryStr time used: $timeUsed");
        }

        // 清空sql
        $this->queryStr = '';

        return $this;
    }

    public function result()
    {
        return $this->result;
    }

    public function rowCount()
    {
        return $this->pdoStatement->rowCount();
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    public function fetch()
    {
        return $this->pdoStatement->fetch();
    }

    public function fetchAll()
    {
        return $this->pdoStatement->fetchAll();
    }


    public function queryAll($tableName)
    {
        $this->prepare("SELECT * FROM " . $this->tablePrefix . $tableName)->execute();
        return $this->fetchAll();
    }

    /**
     * @param $tableName
     * @param $keyAndValues
     * @return string 插入记录的id
     */
    public function insert($tableName, $keyAndValues)
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

        return $this->prepare("insert into " . $this->tablePrefix . $tableName . "({$columnsString}) values 
        ({$placeHolderString})")->execute()->lastInsertId();
    }

    public function update($tableName, $keyAndValues, $whereKeyAndValues)
    {
//        $columns = array_keys($keyAndValues);
//        $columnsString = implode(',', $columns);
//        $placeHolderString = ':' . implode(', :', $columns);
        $this->pdoKeysAndValues = $keyAndValues;
        $this->pdoWhereKeysAndValues = $whereKeyAndValues;

        $setStr = '';
        $index = 0;
        foreach (array_keys($keyAndValues) as $key) {
            if ($index != 0) {
                $setStr = $setStr . ', ';
            }
            $keyOK = $this->replaceDots($key);
            $setStr = $setStr . "{$key}=:{$keyOK}";

            $index++;
        }

        $whereStr = '';
        $index = 0;
        foreach (array_keys($whereKeyAndValues) as $key) {
            if ($index != 0) {
                $whereStr = $whereStr . ', ';
            }
            $keyOK = $this->replaceDots($key);
            $whereStr = $whereStr . "{$key}=:{$keyOK}";

            $index++;
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
        return $this->prepare("update " . $this->tablePrefix . $tableName . " set {$setStr} where ({$whereStr})")
            ->execute()
            ->rowCount();
    }

    /**
     * 查询快捷方法
     * @param $model BaseModel
     * @param $whereKeyAndValues
     *          Only support AND condition
     * @return array
     */
    public function query($tableName, $whereKeyAndValues = '', $orderBy = '', $limit = '')
    {
        // set value
        $this->pdoWhereKeysAndValues = $whereKeyAndValues;

        $whereStr = '';
        $index = 0;
        if ($whereKeyAndValues != '') {
            foreach (array_keys($whereKeyAndValues) as $key) {
                if ($index != 0) {
                    $whereStr = $whereStr . ' AND ';
                }
                $keyOK = $this->replaceDots($key);
                $whereStr = $whereStr . "{$key}=:{$keyOK}";

                $index++;
            }
        }

        $sql = "SELECT * FROM " . $this->tablePrefix . $tableName;
        if ($whereStr != '') {
            $sql .= "where ({$whereStr})";
        }

        $this->prepare("$sql ORDER BY $orderBy LIMIT $limit")
            ->execute();

        return $this->pdoStatement->fetchAll();
    }

    // TODO: make this one to soft delete
    /**
     * @param $tableName
     * @param $whereKeyAndValues
     *          Values could be a array, will build sql string use IN word
     * @return int
     */
    public function delete($tableName, $whereKeyAndValues)
    {
        // set value
        $this->pdoWhereKeysAndValues = $whereKeyAndValues;

        $whereStr = '';
        $index = 0;
        foreach (array_keys($whereKeyAndValues) as $key) {
            if ($index != 0) {
                $whereStr = $whereStr . ' AND ';
            }
            $keyOK = $this->replaceDots($key);

            // If value is array, use IN
            if(is_array($whereKeyAndValues[$key])){
                $whereStr = $whereStr . "{$key} IN (:{$keyOK})";
                $this->pdoWhereKeysAndValues[$key] = implode(',', $whereKeyAndValues[$key]);
            } else {
                $whereStr = $whereStr . "{$key}=:{$keyOK}";
            }

            $index++;
        }

        return $this->prepare("delete from " . $this->tablePrefix . $tableName . " where ({$whereStr})")->execute()
            ->rowCount();
//
//         $this->pdoStatement->fetchAll();
    }

    /**
     * 查询表的总记录数
     * @param $tableName
     * @return array
     */
    public function count($tableName)
    {
        $this->prepare("SELECT count(*) FROM " . $this->tablePrefix . $tableName)
            ->execute();
        return $this->pdoStatement->fetchAll();
    }

    /**
     * 直接执行sql语句
     * @param $sql
     * @return array
     */
    public function sql($sql)
    {
        return $this->prepare($sql)->execute()->fetchAll();
    }

    private function replaceDots($key)
    {
        return str_replace('.', '_', $key);
    }

}