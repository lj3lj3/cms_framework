<?php
require_once dirname(dirname(__FILE__)) . '/BaseController.php';
require_once dirname(dirname(dirname(__FILE__))) . "/Model/Permission/User.php";

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/9
 * Time: 15:02
 */
class PermissionController extends BaseController
{
    public function getAllUser()
    {
        $user = new User();
        var_dump($user->all());
    }

    public function getAllUserPermission()
    {
        $user = new User(1);
        var_dump($user->allWithRoles());
        echo '--------------------------';
        $user = new User(1);
        var_dump($user->allWithPermission());
    }
}