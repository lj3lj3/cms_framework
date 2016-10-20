<?php
require_once 'Pipeline.php';
require_once dirname(dirname(__FILE__)) . '/Router.php';
//namespace Core\Middleware;

//use Core\Request;
/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/26
 * Time: 15:51
 */

/**
 * 定义中间件接口,所有中间间都必须继承
 * Interface Middleware
 */
class Middleware
{
    /**
     * @var Middleware
     */
    protected $middlewareNext;
    protected $pipes;

    /**
     * @param $request Request
     * @param $pipes array
     */
    public function handler($request, $pipes)
    {
        $this->middlewareNext = Pipeline::make(array_pop($pipes));
        $this->pipes = $pipes;


        Middleware::handleStatic($this->middlewareNext, $request, $this->pipes);
//        if (!Middleware::route($this->middlewareNext, $request)) {
//            $this->middlewareNext->handler($request, $pipes);
//        }
        /*if (count($pipes) == 0) {
            // 最后一个是Router
            $this->router = $this->middlewareNext;
            $this->router->direct($request->uri());
            return true;
        }*/
//        $this->middlewareNext = array_pop($pipes);
//        return false;
    }

    public static function handleStatic($middleware, $request, $pipes)
    {
        // 到路由了
        if ($middleware instanceof Router) {
            // 最后一个是Router
            $router = $middleware;
            $router->direct($request->uri());
            return true;
        }
        $middleware->handler($request, $pipes);
    }
}
