<?php

require_once 'Middleware.php';

/**
 * 使用这个中间件来添加网站通用的cookie
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/26
 * Time: 16:08
 */
class SessionMiddleware extends Middleware
{

    public function handler($request, $pipes)
    {
        // 开启session
        session_start();

        parent::handler($request, $pipes);

    }

}