<?php
/**
 * Created by PhpStorm.
 * User: lj3lj
 * Date: 9/21/2016
 * Time: 11:05 PM
 */

//namespace Core;
defined('IN_CMS') or exit('No direct script access allowed');

require dirname(__FILE__) . '/Log/Log.php';
require 'Exception.php';
require dirname(dirname(__FILE__)) . '/vendor/smarty/libs/Smarty.class.php';
require 'DB.php';
require 'Util.php';
require dirname(dirname(__FILE__)) . '/vendor/swcms/Page.class.php';
// Load template
require 'Template.php';

// Log启动
Log::boot(new FileLogHandler());

// For now
define('ERROR_REPORT', 3);
define('tpl_dir', dirname(dirname(__FILE__)) . '/templates/');

// Set error reporting
if(ERROR_REPORT==1) {
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
} elseif(ERROR_REPORT==0) {
    error_reporting(0);
} else {
    error_reporting(E_ALL);
}
set_error_handler('error_handler');
set_exception_handler('exception_handler');

// Load template
$tpl = new Template();

// Load plugins
//foreach ($GLOBALS['config']['plugin'] as $plugin => $value) {
//    if ($plugin == 'smarty' && $value == true) {
//        $smarty = new Smarty();
//        //var_dump( $smarty);

//        $smarty->setTemplateDir(dirname(dirname(__FILE__)) . '/resource/views/templates/');
//        $smarty->setCompileDir(dirname(dirname(__FILE__)) . '/resource/views/templates_c/');
//        $smarty->setConfigDir(dirname(dirname(__FILE__)) . '/resource/views/configs/');
//        $smarty->setCacheDir(dirname(dirname(__FILE__)) . '/resource/views/cache/');
//
//        //$smarty->testInstall();
//    }
//}

// start session
session_start();



function getUrlPieces()
{
    return explode('/', trim($_SERVER['REDIRECT_URL'], '/'));
}

function getFirstUrlPiece()
{
    $pieces = getUrlPieces();
    return $pieces[0];
}

/**
 * 从GET和POST请求中获取到参数
 * @param $name
 * @param string $default
 * @return string
 */
function getRequestParam($name, $default = '')
{
    $value = $default;
    if (isset($_GET[$name])) {
        $value = $_GET[$name];
    } else if (isset($_POST[$name])) {
        $value = $_POST[$name];
    }
    return $value;
}

function redirect()
{
    $uriPis = getUrlPieces();

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

    require 'Controller/BaseController.php';
    require $controllerUri;
    // call this method
    $controller = new $realClassName;
//        $controller->$functionName();
    call_user_func(array($controller, $functionName));
}
