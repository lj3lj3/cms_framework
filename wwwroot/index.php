<?php
/**
 * Created by PhpStorm.
 * User: lj3lj
 * Date: 9/21/2016
 * Time: 11:02 PM
 */
//use Core\Request;
//use Core\Router;
//use Core\Middleware\Pipeline;

require dirname(__FILE__) . '/../core/Request.php';
require dirname(__FILE__) . '/../core/Router.php';
require dirname(__FILE__) . '/../core/boot.php';
//require dirname(dirname(__FILE__)) . '/core/Middleware/Pipeline.php';
$routeFile = dirname(__FILE__) . '/../routes/web.php';

/*$uri = Request::uri();

$parameters = Request::parameters();

$method = Request::method();

$post = Request::POST();*/

$request = new Request();

// middleware
//public function middleware(Pipeline $pipeline){
//$pipeline = new Pipeline();
//$result = $pipeline->send($request)->through($GLOBALS['config']['middleware'])->go(function ($request) use ($routeFile) {
$router = new Router();

require $routeFile;

$router->direct($request->uri());
//});

/*if (!($result instanceof Request)) {
    throw new \Exception('Interrupt by middleware!');
}*/
//return $this;
//}


//require '../routes/web.php';


//$route->direct($uri);
