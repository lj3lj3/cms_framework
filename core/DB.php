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

    // protected 用于之后继承
    protected $pdo;
    protected $pdoStatement;
    protected $fetchMode = null;
    protected $pdoKeysAndValues = null;
    protected $pdoWhereKeysAndValues = null;

    public function __construct($dbConfigName)
    {
        if (array_key_exists($dbConfigName, $GLOBALS['config']['database'])) {
            $dbConfigs = $GLOBALS['config']['database'][$dbConfigName];
            $this->pdo = new PDO("{$dbConfigs['db']}:host={$dbConfigs['host']};charset={$dbConfigs['charset']};
            dbname={$dbConfigs['dbname']}", $dbConfigs['name'], $dbConfigs['password']);
        } else {
            echo "not fonund this db config: $dbConfigName";
        }

//        $this->fetchMode = PDO::FE
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
     * 返回PDOstatement
     */
    public function prepare($sql, $keyAndValues = null, $whereKeyAndValues = null)
    {
        try {
            $this->pdoStatement = $this->pdo->prepare($sql);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }


        // Set fetch mode
        if ($this->fetchMode != null) {
            $this->pdoStatement->setFetchMode($this->fetchMode);
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
                $this->pdoStatement->bindValue($key, $value);
            }
        }

        if ($this->pdoWhereKeysAndValues != null) {
            // bind everything
            foreach ($this->pdoWhereKeysAndValues as $key => $value) {
                $this->pdoStatement->bindValue($key, $value);
            }
        }

    }

    public function bindValue($keyAndValue)
    {
        $this->pdoKeysAndValues = $keyAndValue;
        $this->doBindValue();
    }

    public function setFetchMode($fetchMode)
    {
        $this->fetchMode = $fetchMode;
//        $this->pdoStatement->setFetchMode($fetchMode);
    }

    public function execute($keyAndValues = null)
    {
        // if keyAndValue is not blank, bind it
        if ($keyAndValues != null) {
            $this->pdoKeysAndValues = $keyAndValues;
            $this->doBindValue();
        }
        return $this->pdoStatement->execute();
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
        $placeHolderString = ':' . implode(', :', $columns);
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
            $setStr = $setStr . "{$key}=:{$key}";

            $index ++;
        }

        $whereStr = '';
        $index = 0;
        foreach (array_keys($whereKeyAndValues) as $key) {
            if($index != 0){
                $whereStr = $whereStr . ', ';
            }
            $whereStr = $whereStr . "{$key}=:{$key}";

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
     * @param BaseModel $model
     * @param $whereKeyAndValues Only support AND condition
     * @return mixed
     */
    public function query(BaseModel $model, $whereKeyAndValues)
    {
        // set value
        $this->pdoWhereKeysAndValues = $whereKeyAndValues;

        $whereStr = '';
        $index = 0;
        foreach (array_keys($whereKeyAndValues) as $key) {
            if($index != 0){
                $whereStr = $whereStr . ' AND ';
            }
            $whereStr = $whereStr . "{$key}=:{$key}";

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
            $whereStr = $whereStr . "{$key}=:{$key}";

            $index ++;
        }

        return $this->prepare("delete from {$model->getTableName()} where ({$whereStr})")->execute();
//
//         $this->pdoStatement->fetchAll();
    }


    private $queryStr;

    /**
     * TODO: 通过的builder构建
     * 现在暂时只考虑具有外链关联的多张表的自动关联
     * @param $selectedColumns
     * @param $models
     */
    public function queryBuilder($selectedColumns, $models)
    {
        $selectedColStr = '';
        $selectedColStr = implode(', ', $selectedColumns);




        $this->queryStr = "select ";
    }
}