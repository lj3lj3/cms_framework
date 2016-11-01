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

    public $id;

    // 默认数据库配置项
    protected $dbConfig = 'mysql';
    // 数据表的前缀 从配置文件中读取
    protected $tablePrefix = '';

    /**
     * 需使用getTableName获取到带有前缀的数据表名
     * @var string
     */
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

    public static function newInstance($id = null)
    {
        return new static($id);
    }

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

    public function setFetchMode($fetchMode = null, $fetchClass = null)
    {
        if ($fetchMode != null) {
            $this->fetchMode = $fetchMode;
        }

        if ($fetchClass != null) {
            $this->fetchClass = $fetchClass;
        }
        $this->db->setFetchMode($this->fetchMode, $this->fetchClass);
        return $this;
    }

    /**
     * @return string 返回带有前缀的数据表名
     */
    public function getTableName()
    {
        return $this->tablePrefix.$this->tableName;
    }

    public function all()
    {
        return $this->db->queryAll($this);
    }

    /**
     * TODO: 自动匹配值并进行自动赋值操作
     * @return mixed
     */
    public abstract function save();

    /**
     * 将对象转换成数组 用于前台显示
     * @return mixed 包含全部变量的数组
     */
    public abstract function toArray();

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

    public function on($modelLeft, $columnLeft, $modelRight, $columnRight)
    {
        $this->db->on($modelLeft, $columnLeft, $modelRight, $columnRight);
        return $this;
    }

    /**
     * 读取whereKeyAndValue作为限定参数
     * @param array $operations
     * @return $this
     */
    public function where($operations = array('='))
    {
        $this->db->where($this->whereKeyAndValue, $operations);
        return $this;
    }

    // TODO: 传入Model使用model中的限制条件 或者使用自身作为限制条件
    public function whereModel()
    {

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

    public function prepare($sql = null)
    {
        $this->db->prepare($sql, $this->keyAndValue, $this->whereKeyAndValue);
        return $this;
    }

    public function execute()
    {
        $this->db->execute($this->keyAndValue);
        return $this;
    }

    public function fetchAll()
    {
        return $this->db->fetchAll();
    }

    public function fetch()
    {
        return $this->db->fetch();
    }

    /**
     * 依次调用prepare execute fetchAll函数
     * @return array
     */
    public function justRun()
    {
        return $this->db->prepare()->execute()->fetchAll();
    }
}