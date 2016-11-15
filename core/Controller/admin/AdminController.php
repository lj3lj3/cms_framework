<?php

//require_once dirname(dirname(dirname(__FILE__))) . "/Model/BaseModel.php";
//require_once dirname(dirname(dirname(__FILE__))) . "/Model/Permission/User.php";
//require_once dirname(dirname(__FILE__)) . '/BaseController.php';
//require_once dirname(dirname(dirname(__FILE__))) . "/Session.php";
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
    const TAG = "AdminController";

    public function index()
    {
        if (!isset($_SESSION["username"])) {
            $this->login();
            return;
        }

        $this->smarty->display(tpl_dir . 'admin/index.tpl');
    }

    public function login()
    {
        // If user already login, return to index
        if (isset($_SESSION["username"])) {
            header("Location: /admin");
            return;
        }

        $this->smarty->display(tpl_dir . 'admin/login/index.tpl');
    }

    /**
     * 客户POST提交登录信息
     */
    public function doLogin()
    {
//        urlencode($_POST['adminname']);
//        urlencode($_POST['password']);
        $username = urlencode($_POST['adminname']);
        $password = urlencode($_POST['password']);

        $db = new DB();
        $result = $db->query('user', array(
            'name' => $username,
            'password' => $password,
        ));

        if(count($result) != 0){
            $message = "{'title': '登录成功！','content': ''}";
            $_SESSION['username'] = $username;
            //TODO: 改进方案 1.返回给客户端一个页面 2.AJAX请求这个函数，都在客户端做跳转
            header("Location: /admin");
            //TODO: If remember password checkbox is checked, write user info into the cookies
        } else {
            $message = "{'title': '登录失败！','content': '用户名或密码错误'}";
        }

        echo $message;

        Log::info(AdminController::TAG, "$message");
    }

    public function logout()
    {
        Log::info(AdminController::TAG, $_SESSION['username'] . " is logout");
        unset($_SESSION['username']);
        header("Location: /admin");
    }
}

//$controller = new AdminController();
//$controller->index();
