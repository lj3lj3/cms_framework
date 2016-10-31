<?php

/**
 * Created by PhpStorm.
 * User: lj3lj
 * Date: 9/21/2016
 * Time: 11:33 PM
 */
//namespace Core;

class Router
{
    protected $routes = array();

//    public static function load($file)
//    {
//        $router = new static;
//
//        require $file;
//
//        return $router;
//    }

    public function define($routes)
    {
        $this->routes = $routes;
    }

    /**
     * @param $request Request
     */
    public function direct($request)
    {

        if(array_key_exists($request->uri(), $this->routes)) {
//            echo "success";
            require $this->routes[$request->uri()];

            return;
        }

        // call default direct
        $this->defaultDirect($request);
    }

    /**
     * @param $request Request
     *
     * URI自动匹配算法：<br>
     * 失效 -- /admin/edit => AdminController#edit <br>
     * 失效 -- /admin/admin/edit => /admin/AdminController#edit <br>
     * <br>
     * 多个IndexController需要namespace支持 php5.3 <br>
     * / => IndexController#index <br>
     * /admin/ => /admin/IndexController#index <br>
     * /admin/edit => /admin/IndexController#edit <br>
     * /admin/post/edit => /admin/PostController#edit <br>
     * /admin/author/post/edit => /admin/author/PostController#edit <br>
     * <br>
     * 在php<5.3的版本中将默认的IndexController换成与dirName相同的类名 <br>
     * / => IndexController#index <br>
     * /admin/ => /admin/AdminController#index <br>
     * /admin/edit => /admin/AdminController#edit <br>
     * /admin/post/edit => /admin/PostController#edit <br>
     * /admin/author/post/edit => /admin/author/PostController#edit <br>
     */
    private function defaultDirect($request)
    {
        // url will be '' if user request root
        $uriPis = $request->UriPieces();

        $dirName = '';
        $className = "Index";
        $functionName = "index";

        $pisCount = count($uriPis);
        if ($pisCount == 1 && $uriPis[0] == '') {
            // User request root directory
            // Use default
        } else if ($pisCount == 1 && $uriPis[0] != '') {
            // User request 1-level directory
            $dirName = $uriPis[0] . '/';
            // 为兼容PHP<5.3
            $className = ucfirst($uriPis[0]);
        } else if ($pisCount == 2) {
            // User request 2-level directory, use the second dir name as method name
            $dirName = $uriPis[0] . '/';
            // 为兼容PHP<5.3
            $className = ucfirst($uriPis[0]);
            $functionName = $uriPis[1];
        } else {
            // More than 2-level directory
            $functionName = $uriPis[$pisCount-1];
            $className = ucfirst($uriPis[$pisCount-2]);
            // Cut the last two and glue it together
            $dirName = implode('/', array_slice($uriPis, 0, $pisCount-2)) . '/';
        }

        // use namespace
//        $path = implode('\\', $uriPis);
//        $realClassName =  "\\Core\\Controller\\{$path}Controller";
        $realClassName =  "{$className}Controller";
        $controllerUri = 'Controller/' . $dirName . $realClassName. '.php';
        // Check the file exists or not
        if (!file_exists(dirname(__FILE__) . "/" . $controllerUri)) {
            throw new Exception(dirname(__FILE__) . "/" . $controllerUri . " does not exists!");
        }

        require $controllerUri;
        // call this method
        $controller = new $realClassName;
//        $controller->$functionName();
        call_user_func(array($controller, $functionName));
    }
}