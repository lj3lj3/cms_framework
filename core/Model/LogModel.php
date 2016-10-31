<?php
require_once 'BaseModel.php';
require_once dirname(dirname(__FILE__)) . '/Util.php';

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/10/10
 * Time: 16:24
 */
class LogModel extends BaseModel
{
    const TABLE_NAME = "log";

    const C_USER_ID = "user_id";
    const C_IP = "ip";
    const C_BROWSER = 'browser';
    const C_ACTION = "action";
    const C_DATE = "date";

    // For PDO
//    public $id;
    public $user_id;
    public $ip;
    public $browser;
    public $action;
    public $date;

    public function __construct()
    {
        parent::__construct();
        $this->tableName = LogModel::TABLE_NAME;
        $this->setFetchMode($this->fetchMode, get_class($this));
    }

    public function save()
    {
        $this->keyAndValue = $this->toArray();
        $this->doInsert();
    }

    /**
     * 将对象转换成数组 用于前台显示
     * @return mixed 包含全部变量的数组
     */
    public function toArray()
    {
        return array(
            LogModel::C_USER_ID => $this->user_id,
            LogModel::C_IP => $this->ip,
            LogModel::C_BROWSER => $this->browser,
            LogModel::C_ACTION => $this->action,
            LogModel::C_DATE => Util::getFormattedDateForDB(),
        );
    }
}