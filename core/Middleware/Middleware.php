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
 * 定义中间件接口，所有中间件都需要继承
 * 子类中重写handler方法，并调用parent::handler方法实现中间件的传递
 * Class Middleware
 */
class Middleware
{

    /**
     * 子类中重写后调用parent::handler方法实现中间件的传递
     * @param $request Request
     * @param $pipes array
     */
    public function handler($request, $pipes)
    {
        $middlewareNext = Pipeline::make(array_pop($pipes));

        Middleware::handleStatic($middlewareNext, $request, $pipes);
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

    /**
     * @param $middleware Middleware
     * @param $request Request
     * @param $pipes Array
     * @return bool
     */
    public static function handleStatic($middleware, $request, $pipes)
    {
        // 到路由了
        if ($middleware instanceof Router) {
            // 最后一个是Router
            $router = $middleware;
            $router->direct($request);
            return true;
        }
        $middleware->handler($request, $pipes);
    }
}
