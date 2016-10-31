<?php

require_once dirname(dirname(__FILE__)) . "/Session.php";

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/9
 * Time: 11:39
 */
class PermissionMiddleware extends Middleware
{

    public function handler($request, $pipes)
    {
        $this->handlePermission($request);

        parent::handler($request, $pipes);

//        echo "end permission<br>";

    }

    /**
     * @param $request Request
     * <br>对用户权限进行校验
     */
    private function handlePermission($request)
    {
        // Only check if user is not at login page
        if ($request->firstUriPiece() == "admin" && $request->uri() != "admin/login" && $request->uri() !=
            "admin/doLogin") {
            Session::checkUserLogin();
        }

        /*switch ($request->uri()) {
            default:
                break;
        }*/
    }
}