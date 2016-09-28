<?php
/**
 * Created by PhpStorm.
 * User: lj3lj
 * Date: 9/21/2016
 * Time: 11:02 PM
 */
use Core\Request;
use Core\Router;
use Core\Middleware\Pipeline;

require __DIR__ . '/../core/Request.php';
require __DIR__ . '/../core/Router.php';
require __DIR__ . '/../core/boot.php';
require dirname(__DIR__) . '/core/Middleware/Pipeline.php';
$routeFile = __DIR__ . '/../routes/web.php';

/*$uri = Request::uri();

$parameters = Request::parameters();

$method = Request::method();

$post = Request::POST();*/

$request = Request::newInstance();

// middleware
//public function middleware(Pipeline $pipeline){
$pipeline = new Pipeline();
$result = $pipeline->send($request)->through($GLOBALS['config']['middleware'])->go(function ($request) use ($routeFile) {
    Router::load($routeFile)->direct($request->uri());
});

/*if (!($result instanceof Request)) {
    throw new \Exception('Interrupt by middleware!');
}*/
//return $this;
//}


//require '../routes/web.php';


//$route->direct($uri);
