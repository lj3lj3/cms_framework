<?php
require_once dirname(dirname(__FILE__)) . '/Model/LogModel.php';

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/10
 * Time: 15:12
 */
interface LogHandler
{
    /**
     * 写入日志
     * @param $msg
     * @return mixed
     */
    public function write($msg);

    /**
     * @param $log LogModel
     * @return mixed
     */
    public function writeModel($log);
}