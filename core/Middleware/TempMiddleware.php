<?php

require_once 'Middleware.php';

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/26
 * Time: 16:08
 */
class TempMiddleware implements Middleware
{
    /**
     * 中间件执行
     * @param Request $request
     * @return mixed
     */
    public function handler(Request $request, Closure $next)
    {
//        if ($request->uri() == 'article/block') {
//            echo "block</br>";
//            echo "mod uri";
//            $request->setUri('article/create');
//            return;
//        }
        echo "temp before handler</br>";

        $next($request);
        echo "temp after handler</br>";
        return;
    }
}