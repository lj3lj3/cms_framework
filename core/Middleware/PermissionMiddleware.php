<?php

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/9
 * Time: 11:39
 */
class PermissionMiddleware implements Middleware
{

    /**
     * 中间件执行
     * @param Request $request
     * @return mixed
     */
    public function handler(Request $request, Closure $next)
    {

        $next($request);
    }
}