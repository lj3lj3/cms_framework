<?php
require_once 'LogHandler.php';

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/10
 * Time: 15:13
 */
class FileLogHandler implements LogHandler
{
    private $logfile;

    private $handler;

    /**
     * 默认记录到当天的日志文件中
     * FileLogHandler constructor.
     */
    public function __construct()
    {
        $this->logfile = dirname(dirname(dirname(__FILE__))) . '/storage/log/' . date('Y-m-d') . '.log';
    }

    public function __destruct()
    {

    }

    public function write($msg)
    {
        $this->handler = fopen($this->logfile, 'a+');

        if (!$this->handler) {
            throw new Exception("打开日志文件错误");
        }

        fwrite($this->handler, date('Y-m-d H-i-s') . " " . $msg . " " . PHP_EOL);

        fclose($this->handler);
    }

    /**
     * @param $log LogModel
     * @return mixed
     */
    public function writeModel($log)
    {
        // TODO: Implement writeModel() method.
    }
}