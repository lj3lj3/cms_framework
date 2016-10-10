<?php
/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/10
 * Time: 14:19
 */

function exception_handler(Exception $exception)
{
    echo '<b>Exception:</b>' . $exception->getMessage();
}

function error_handler($errno, $errstr, $errfile, $errline)
{

}