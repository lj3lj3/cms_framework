<?php
namespace Core\Model;

/**
 * Created by PhpStorm.
 * User: lj3lj
 * Date: 9/22/2016
 * Time: 12:33 AM
 */
require_once dirname(dirname(__FILE__)) . '/DB.php';

class BaseModel
{
    const C_ID = 'id';

    // 默认数据库配置项
    protected $dbConfig = 'mysql';

    protected $tableName = '';

    protected $db;

    // key and value for insert and update
    protected $keyAndValue;

    // key and value for insert and update
    protected $whereKeyAndValue;

    // default fetch mode
    protected $fetchMode = PDO::FETCH_OBJ;

    public static function newInstance()
    {
        return new static();
    }

    public function __construct()
    {
        $this->db = new DB($this->dbConfig);
//        $this->db->setFetchMode(PDO::FETCH_OBJ);
    }

    public function setFetchMode($fetchMode)
    {
        $this->db->setFetchMode($fetchMode);
    }

    public function getTableName()
    {
        return $this->tableName;
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
}