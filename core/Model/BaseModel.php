<?php
//namespace Core\Model;

/**
 * Created by PhpStorm.
 * User: lj3lj
 * Date: 9/22/2016
 * Time: 12:33 AM
 */
require_once dirname(dirname(__FILE__)) . '/DB.php';

abstract class BaseModel
{
    const C_ID = 'id';
    const TABLE_PREFIX = 'tableprefix';

    // 默认数据库配置项
    protected $dbConfig = 'mysql';
    // 数据表的前缀 从配置文件中读取
    protected $tablePrefix = '';

    protected $tableName = '';

    protected $db;

    // key and value for insert and update
    protected $keyAndValue;

    // key and value for select, delete and update
    protected $whereKeyAndValue;

    // default fetch mode
    protected $fetchMode;
    // fetch class
    protected $fetchClass;

    /*public static function newInstance()
    {
        return new self();
    }*/

    public function __construct()
    {
        $this->db = new DB($this->dbConfig);
        if (array_key_exists($this->dbConfig, $GLOBALS['config']['database'])) {
            $this->tablePrefix = $GLOBALS['config']['database'][$this->dbConfig][BaseModel::TABLE_PREFIX];
        } else {
            echo "";
        }
//        $this->db->setFetchMode(PDO::FETCH_OBJ);
        $this->fetchMode = PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE;
    }

    public function setFetchMode($fetchMode, $fetchClass)
    {
        $this->db->setFetchMode($fetchMode, $fetchClass);
    }

    public function getTableName()
    {
        return $this->tablePrefix.$this->tableName;
    }

    public function all()
    {
        return $this->db->queryAll($this);
    }

    public function doInsert()
    {
        return $this->db->insert($this, $this->keyAndValue);
    }

    public function doQuery()
    {
        return $this->db->query($this, $this->whereKeyAndValue);
    }

    public function doUpdate()
    {
        return $this->db->update($this, $this->keyAndValue, $this->whereKeyAndValue);
    }

    public function doDelete()
    {
        return $this->db->delete($this, $this->whereKeyAndValue);
    }


    public function queryBuilder($selectedColumns)
    {
        $this->db->queryBuilder($selectedColumns, $this);
        return $this;
    }

    public function join($model)
    {
        $this->db->join($model);
        return $this;
    }

    public function rightJoin($model)
    {
        $this->db->rightJoin($model);
        return $this;
    }

    public function on($models, $columns)
    {
        $this->db->on($models, $columns);
        return $this;
    }

    public function where($operations = array('='))
    {
        $this->db->where($this->whereKeyAndValue, $operations);
        return $this;
    }

    public function orderBy($orderColumns, $descOrAsc)
    {
        $this->db->where($orderColumns, $descOrAsc);
        return $this;
    }

    public function limit($count, $offset = 0)
    {
        $this->db->limit($count, $offset);
        return $this;
    }
}