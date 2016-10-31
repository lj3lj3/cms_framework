<?php

require_once dirname(__FILE__) . "/Model/Permission/User.php";

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/31
 * Time: 11:40
 */
class Session
{
    public static function checkUserLogin()
    {
        if (!isset($_SESSION[User::C_NAME])) {
            header("Location: /admin/login");
            return false;
        };

        return true;
    }

    public static function isUserLogin()
    {
        return isset($_SESSION[User::C_NAME]);
    }

    public static function userLogin($username)
    {
        $_SESSION[User::C_NAME] = $username;
    }

    public static function userLogout()
    {
        unset($_SESSION[User::C_NAME]);
    }
}