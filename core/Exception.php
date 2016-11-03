<?php
/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/10
 * Time: 14:19
 */

function exception_handler(Exception $exception)
{
    $exceptionStr = '出错了<br>' . '<b>Exception:</b>' . $exception->getMessage();
    if ($GLOBALS['config']['debug'] == true) {
        echo $exceptionStr;
    }
    Log::error("Exception", $exceptionStr);
}

function error_handler($errno, $errstr, $errfile, $errline)
{
    $errorStr = '出错了<br>' . "<b>Error:</b>错误代码：$errno<br>错误信息：$errstr<br>错误文件：$errfile<br>错误位置：$errline<br>";
    if ($GLOBALS['config']['debug'] == true) {
        echo $errorStr;
    }
    Log::error("Error", $errorStr);
}
