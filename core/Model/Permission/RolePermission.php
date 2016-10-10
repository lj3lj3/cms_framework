<?php
require_once dirname(dirname(__FILE__)) . '/BaseModel.php';

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/9
 * Time: 11:43
 */
class RolePermission extends BaseModel
{
    const TABLE_NAME = "role_per";

    const C_ROLE_ID = "role_id";
    const C_PERMISSION_ID = "permission_id";
    const C_CREATE_DATE = "create_date";

    // For PDO
//    public $id;
    public $role_id;
    public $permission_id;
    public $create_date;

    public function __construct()
    {
        parent::__construct();
        $this->tableName = RolePermission::TABLE_NAME;
        $this->setFetchMode($this->fetchMode, get_class($this));
    }

    public function save()
    {
        // TODO: Implement save() method.
    }
}