<?php

require_once 'Middleware.php';

/**
 * 使用这个中间件来添加网站通用的cookie
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/26
 * Time: 16:08
 */
class CookieMiddleware extends Middleware
{


    public function handler($request, $pipes)
    {
        echo "before cookie<br>";

        parent::handler($request, $pipes);

        echo "after cookie<br>";

    }

}