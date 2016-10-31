<?php
require_once dirname(dirname(__FILE__)) . '/BaseModel.php';

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/9
 * Time: 11:42
 */
class UserRole extends BaseModel
{
    const TABLE_NAME = "user_role";

    const C_USER_ID = "user_id";
    const C_ROLE_ID = "role_id";
    const C_CREATE_DATE = "create_date";

    // For PDO
//    public $id;
    public $user_id;
    public $role_id;
    public $create_date;

    public function __construct()
    {
        parent::__construct();
        $this->tableName = UserRole::TABLE_NAME;
        $this->setFetchMode($this->fetchMode, get_class($this));
    }

    public function save()
    {
        // TODO: Implement save() method.
    }

    /**
     * 将对象转换成数组 用于前台显示
     * @return mixed 包含全部变量的数组
     */
    public function toArray()
    {
        // TODO: Implement toArray() method.
    }
}