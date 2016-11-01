<?php
require_once 'FileLogHandler.php';
require_once 'DBLogHandler.php';

/**
 * 默认使用文件存储方式
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/10
 * Time: 14:52
 */
class Log
{
    /**
     * @var Log
     */
    private static $instance = null;
    /**
     * @var LogHandler
     */
    private $logHandler;

    public function __construct($logHandler)
    {
        $this->logHandler = $logHandler;
    }

    public function log($msg)
    {
        $this->logHandler->write($msg);
    }

    public function log_model($logModel)
    {
        $this->logHandler->writeModel($logModel);
    }

    public static function boot($logHandler = null)
    {
        if (!$logHandler) {
            $logHandler = new FileLogHandler();
        }

        Log::$instance = new Log($logHandler);
    }

    public static function debug($tag, $msg)
    {
        Log::$instance->log("debug:[$tag]$msg");
    }

    public static function info($tag, $msg)
    {
        Log::$instance->log("info:[$tag]$msg");
    }

    public static function notice($tag, $msg)
    {
        Log::$instance->log("notice:[$tag]$msg");
    }

    public static function warning($tag, $msg)
    {
        Log::$instance->log("warning:[$tag]$msg");
    }

    public static function error($tag, $msg)
    {
        Log::$instance->log("error:[$tag]$msg");
    }

    public static function alert($tag, $msg)
    {
        Log::$instance->log("alert:[$tag]$msg");
    }

    public static function emergency($tag, $msg)
    {
        Log::$instance->log("emergency:[$tag]$msg");
    }

    public static function logModel($logModel)
    {
        Log::$instance->log_model($logModel);
    }
}