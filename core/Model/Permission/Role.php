<?php
require_once dirname(dirname(__FILE__)) . '/BaseModel.php';

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/9
 * Time: 11:42
 */
class Role extends BaseModel
{
    const TABLE_NAME = "role";

    const C_NAME = "name";
    const C_CREATE_DATE = "create_date";

    // For PDO
//    public $id;
    public $name;
    public $create_date;

    public function __construct()
    {
        parent::__construct();
        $this->tableName = Role::TABLE_NAME;
        $this->setFetchMode($this->fetchMode, get_class($this));
    }

    public function save()
    {
        // TODO: Implement save() method.
    }
}