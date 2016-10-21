<?php
/**
 * Created by PhpStorm.
 * User: lj3lj
 * Date: 9/21/2016
 * Time: 11:19 PM
 */

require_once dirname(dirname(dirname(__FILE__))) . "/Model/BaseModel.php";
require_once dirname(dirname(dirname(__FILE__))) . "/Model/Permission/User.php";
require_once dirname(dirname(__FILE__)) . '/BaseController.php';


class LoginController extends BaseController {
    const TAG = "LoginController";

    const USER_NAME = "adminname";
    const PASSWORD = "password";

    public function login()
    {
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
        $username = $post[LoginController::USER_NAME];
        $user->name = urlencode($username);
        $password = $post[LoginController::PASSWORD];
        $user->password = urlencode($password);

        if($user->exist()){
            $message = "{'title': '登录成功！','content': ''}";
            //TODO: 改进方案 1.返回给客户端一个页面 2.AJAX请求这个函数，都在客户端做跳转
            header("Location: /admin/admin/index");
        } else {
            $message = "{'title': '登录失败！','content': '用户名或密码错误'}";
        }

        echo $message;
    }

    public function logout()
    {

    }
}


