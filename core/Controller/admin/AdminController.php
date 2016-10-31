<?php

require_once dirname(dirname(dirname(__FILE__))) . "/Model/BaseModel.php";
require_once dirname(dirname(dirname(__FILE__))) . "/Model/Permission/User.php";
require_once dirname(dirname(__FILE__)) . '/BaseController.php';
require_once dirname(dirname(dirname(__FILE__))) . "/Session.php";
/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/23
 * Time: 11:19
 */


//require dirname(dirname(dirname(__FILE__))) . "/Model/BaseModel.php";
//require dirname(dirname(__FILE__)) . '/BaseController.php';


class AdminController extends BaseController
{
    const USER_NAME = "adminname";
    const PASSWORD = "password";


    public function index()
    {
        $this->smarty->display($this->tplDir . 'admin/index.tpl');
    }

    public function login()
    {
        // If user already login, return to index
        if (Session::isUserLogin()) {
            header("Location: /admin");
            return;
        }

        $this->smarty->display($this->tplDir . 'admin/login/index.tpl');
    }

    public function doLogin()
    {
        /**
         * @var $request Request
         */
        $request = $GLOBALS['request'];
        $post = $request->POST();

        $user = new User();
        $username = $post[AdminController::USER_NAME];
        $user->name = urlencode($username);
        $password = $post[AdminController::PASSWORD];
        $user->password = urlencode($password);

        if($user->exist()){
            $message = "{'title': '登录成功！','content': ''}";
            Session::userLogin($username);
            //TODO: 改进方案 1.返回给客户端一个页面 2.AJAX请求这个函数，都在客户端做跳转
            header("Location: /admin");
            //TODO: If remember password checkbox is checked, write user info into the cookies
        } else {
            $message = "{'title': '登录失败！','content': '用户名或密码错误'}";
        }

        echo $message;
    }

    public function logout()
    {
        Session::userLogout();
        header("Location: /admin");
    }
}

//$controller = new AdminController();
//$controller->index();
