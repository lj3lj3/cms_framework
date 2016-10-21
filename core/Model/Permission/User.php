<?php
require_once dirname(dirname(__FILE__)) . '/BaseModel.php';
require_once 'UserRole.php';
require_once 'Role.php';
require_once 'RolePermission.php';
require_once 'Permission.php';

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/9
 * Time: 11:42
 */
class User extends BaseModel
{
    const TABLE_NAME = "user";

    const C_NAME = "name";
    const C_PASSWORD = "password";
    const C_DISPLAY_NAME = "display_name";
    const C_EMAIL = "email";
    const C_PHONE = "phone";
    const C_CREATE_DATE = "create_date";

    // For PDO
//    public $id;
    public $name;
    public $password;
    public $display_name;
    public $email;
    public $phone;
    public $create_date;

    protected $roles = array();
    protected $permissions = array();

    public function __construct($id = 0)
    {
        parent::__construct();
        $this->tableName = User::TABLE_NAME;
        $this->setFetchMode($this->fetchMode, get_class($this));
        // Set user id
        $this->id = $id;
    }

    /**
     * 目前设计的情况是存在少数用户
     */
    public function allWithRoles()
    {
//        $models = array($this, new UserRole());
//        $onColumns = array(BaseModel::C_ID, UserRole::C_USER_ID);
        return $this->db->queryBuilder('*', $this)->join(new UserRole())->on($this, BaseModel::C_ID, new UserRole(), UserRole::C_USER_ID)
            ->prepare()->execute()
            ->fetchAll();
    }

    public function allWithPermission()
    {
        $per = new Permission();
//        $selectColumns = array($per->getTableName().'.'.Permission::C_NAME);
        $selectColumns = array($per->getTableName().'.'.Permission::C_NAME);

        $userRole = new UserRole();
//        $userUserRole = array($this, $userRole);
//        $userUserRoleCol = array(User::C_ID, UserRole::C_USER_ID);

        $role = new Role();
//        $userRoleRole = array($userRole, $role);
//        $userRoleRoleCol = array(UserRole::C_ROLE_ID, Role::C_ID);

        $rolePer = new RolePermission();
//        $roleRolePer = array($role, $rolePer);
//        $roleRolePerCol = array(Role::C_ID, RolePermission::C_ROLE_ID);

        $permission = new Permission();
//        $rolePerPer = array($rolePer, $permission);
//        $rolePerPerCol = array(RolePermission::C_PERMISSION_ID, Permission::C_ID);

        $this->whereKeyAndValue = array(
            $this->getTableName().'.'.User::C_ID => $this->id
        );

        return $this->setFetchMode($this->fetchMode, get_class($permission))->queryBuilder($selectColumns)
            ->join($userRole)->on($this, User::C_ID, $userRole, UserRole::C_USER_ID)
            ->join($role)->on($userRole, UserRole::C_ROLE_ID, $role, Role::C_ID)
            ->join($rolePer)->on($role, Role::C_ID, $rolePer, RolePermission::C_ROLE_ID)
            ->join($permission)->on($rolePer, RolePermission::C_PERMISSION_ID, $permission, Permission::C_ID)
            ->where()->justRun();
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPermissions()
    {
        return $this->permissions;
    }

    public function save()
    {
        // TODO: Implement save() method.
    }

    /**
     * 通过用户名和密码确认用户是否存在
     * @return bool
     */
    public function exist()
    {
        $this->whereKeyAndValue = array(
            User::C_NAME => $this->name,
            User::C_PASSWORD => $this->password,
        );

        return count($this->db->query($this, $this->whereKeyAndValue)) != 0;
    }
}