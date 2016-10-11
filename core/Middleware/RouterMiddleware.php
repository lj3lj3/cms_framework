<?php

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/11
 * Time: 9:42
 */
class RouterMiddleware implements Middleware
{

    /**
     * 中间件执行
     * @param Request $request
     * @return mixed
     */
    public function handler(Request $request, Middleware $next)
    {
        $router = new Router();

//    require $routeFile;

        $router->direct($request->uri());
    }
}