<?php
//namespace Core\Middleware;

require_once 'Middleware.php';

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/26
 * Time: 15:39
 */
class Pipeline
{

    /**
     * 触发的方法
     * @var string
     */
    const METHOD = 'handler';
    /**
     * 需要在流水线中处理的对象
     * @var
     */
    private $passable;

    /**
     * 处理者
     * @var
     */
    private $pipes;

    /**
     * 应用实例
     * @var
     */
//    private $app;

//    public function __construct(Application $app){
//        $this->app = $app;
//    }

    /**
     * 设置需要处理的对象
     * @param $request
     * @return $this
     */
    public function send($request){
        $this->passable = $request;
        return $this;
    }

    /**
     * 需要经过哪些中间件处理
     * @param $pipes
     * @return $this
     */
    public function through($pipes){
        $this->pipes = is_array($pipes) ? $pipes : func_get_args();
        return $this;
    }

    /**
     * 开始流水线处理
     */
    public function go($first){
//        $this->pipes = array_reverse($this->pipes);
        $this->pipes[count($this->pipes)] = $first;
        $this->pipes = array_reverse($this->pipes);

        $middlewareStart = Pipeline::make(array_pop($this->pipes));
        Middleware::handleStatic($middlewareStart, $this->passable, $this->pipes);
    }

    /**
     * 开始流水线处理
     * For php > 5.2
     */
    /*public function go(Middleware $first){


        return call_user_func(
            array_reduce(array_reverse($this->pipes),$this->getSlice(),$first),
            $this->passable);
    }*/

    /**
     * 包装迭代对象到闭包
     * For php > 5.2
     * @return Closure
     */
    /*public function getSlice(){
        return function($stack,$pipe){
            return function($passable) use($stack,$pipe){
                if($stack instanceof Middleware){
//                    return call_user_func(array(new $pipe, $this->method),$passable,$stack);
                    return call_user_func(array(Pipeline::make($pipe), Pipeline::METHOD),$passable,$stack);
                }
            } ;
        };
    }*/


    // This is for php > 5.2
    /*public static function make($className)
    {
        if ($className == null || $className instanceof Router) {
            return $className;
        }
//        echo $className;
        $array = explode('\\', $className);
        $fileName = array_pop($array);
//        require 'TempMiddleware.php';
//        echo "{$fileName}.php";
        require "{$fileName}.php";
//        require "TempMiddleware.php";

        return new $className();
    }*/

    public static function make($className)
    {
        if ($className == null || $className instanceof Router) {
            return $className;
        }
//        echo $className;
        //$array = explode('\\', $className);
        //$fileName = array_pop($array);
//        require 'TempMiddleware.php';
//        echo "{$fileName}.php";
        require "{$className}.php";
//        require "TempMiddleware.php";

        return new $className();
    }
}