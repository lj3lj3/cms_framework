<?php
namespace Core\Middleware;

use Core\Request;
/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/26
 * Time: 15:51
 */
/**
 * 定义中间件接口,所有中间间都必须实现该接口
 * Interface Middleware
 */
interface Middleware{
    /**
     * 中间件执行
     * @param Request $request
     * @return mixed
     */
    public function handler(Request $request, \Closure $next);
}