<?php

require_once 'Middleware.php';

/**
 * 使用这个中间件来添加网站通用的cookie
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/26
 * Time: 16:08
 */
class CookieMiddleware implements Middleware
{
    /**
     * 中间件执行
     * @param Request $request
     * @return mixed
     */
    public function handler(Request $request, Closure $next)
    {
//        echo $request->uri();
//        if ($request->uri() == 'article/cookie') {
//            echo "block</br>";
//            return;
//        }
//        echo "cookie before handler</br>";

        $next($request);
//        echo "cookie after handler</br>";
        return;
    }
}