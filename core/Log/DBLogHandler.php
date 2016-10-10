<?php
require_once 'LogHandler.php';

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/10
 * Time: 16:19
 */
class DBLogHandler implements LogHandler
{


    /**
     * 写入日志
     * @param $msg
     * @return mixed
     */
    public function write($msg)
    {

    }

    /**
     * @param $log LogModel
     * @return mixed
     */
    public function writeModel($log)
    {
        $log->save();
    }
}