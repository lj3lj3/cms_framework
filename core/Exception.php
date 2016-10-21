<?php
/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/10
 * Time: 14:19
 */

function exception_handler(Exception $exception)
{
    echo '出错了<br>';
    echo '<b>Exception:</b>' . $exception->getMessage();
}

function error_handler($errno, $errstr, $errfile, $errline)
{
    echo '出错了<br>';
    echo "<b>Error:</b>错误代码：$errno<br>错误信息：$errstr<br>错误文件：$errfile<br>错误位置：$errline<br>";
}
