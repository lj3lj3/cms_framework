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

require_once dirname(__FILE__) . '/../core/Request.php';
require_once dirname(__FILE__) . '/../core/Router.php';
require_once dirname(__FILE__) . '/../core/boot.php';
require_once dirname(dirname(__FILE__)) . '/core/Middleware/Pipeline.php';

//require_once dirname(__FILE__) . '/../routes/web.php';

/*$uri = Request::uri();

$parameters = Request::parameters();

$method = Request::method();

$post = Request::POST();*/

$request = new Request();

// middleware
//public function middleware(Pipeline $pipeline){



// Closure only works on php 5.3 and above
//$result = $pipeline->send($request)->through($GLOBALS['config']['middleware'])->go(function ($request) use ($routeFile) {
$router = new Router();
//
//    require $routeFile;
//
//$router->direct($request->uri());
//});
// 添加debug执行时间调试
$tStart = 0;
if ($GLOBALS['config']['debug'] == true) {
    $tStart = microtime(true);
}
// For php 5.2
$pipeline = new Pipeline();
$result = $pipeline->send($request)->through($GLOBALS['config']['middleware'])->go(new Router());

if ($GLOBALS['config']['debug'] == true) {
    $timeUsed =  microtime(true) - $tStart;
    Log::debug("page", "Time used: $timeUsed");
    echo $timeUsed;
}
/*if (!($result instanceof Request)) {
    throw new \Exception('Interrupt by middleware!');
}*/
//return $this;
//}


//require '../routes/web.php';


//$route->direct($uri);
