<?php
//namespace Core\Middleware;

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
     * @param Closure
     * @return Closure
     */
    public function go(Middleware $first){


        return call_user_func(
            array_reduce(array_reverse($this->pipes),$this->getSlice(),$first),
            $this->passable);
    }

    /**
     * 包装迭代对象到闭包
     * @return Closure
     */
    public function getSlice(){
        return function($stack,$pipe){
            return function($passable) use($stack,$pipe){
                if($stack instanceof Middleware){
//                    return call_user_func(array(new $pipe, $this->method),$passable,$stack);
                    return call_user_func(array(Pipeline::make($pipe), Pipeline::METHOD),$passable,$stack);
                }
            } ;
        };
    }


    public static function make($className)
    {
//        echo $className;
        $array = explode('\\', $className);
        $fileName = array_pop($array);
//        require 'TempMiddleware.php';
//        echo "{$fileName}.php";
        require "{$fileName}.php";
//        require "TempMiddleware.php";

        return new $className();
    }
}