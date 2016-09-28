<?php

/**
 * Created by PhpStorm.
 * User: lj3lj
 * Date: 9/21/2016
 * Time: 11:33 PM
 */
namespace Core;

class Router
{
    protected $routes = array();

    public static function load($file)
    {
        $router = new static;

        require $file;

        return $router;
    }

    public function define($routes)
    {
        $this->routes = $routes;
    }

    public function direct($uri)
    {

        if(array_key_exists($uri, $this->routes)) {
//            echo "success";
            require $this->routes[$uri];

            return;
        }

        // call default direct
        $this->defaultDirect($uri);
    }

    /**
     * URI自动匹配算法：
     * /admin/edit => AdminController@edit
     */
    private function defaultDirect($uri)
    {
        $uriPis = explode('/', $uri);
        $functionName = $uriPis[count($uriPis)-1];
        // This is for class
        unset($uriPis[count($uriPis)-1]);

//        $uriPisComplete = array_slice($uriPis, -1);
        $className = $uriPis[count($uriPis)-1] = ucfirst($uriPis[count($uriPis)-1]);
        // use namespace
        $path = implode('\\', $uriPis);
        $realClassName =  "\\Core\\Controller\\{$path}Controller";
        $controllerUri = 'Controller/' . implode('/', $uriPis) . 'Controller.php';
        // last parameter is function
//        $functionName = $uriPis[count($uriPis)-1];

        require $controllerUri;
        // call this method
        $controller = new $realClassName;
//        $controller->$functionName();
        call_user_func(array($controller, $functionName));

//        $trimedUri = explode("/", $uri);
    }
}