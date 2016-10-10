<?php
//namespace Core\Controller\Temp;

//require dirname(dirname(dirname(__FILE__))) . "/Model/BaseModel.php";
require_once dirname(dirname(dirname(__FILE__))) . "/DB.php";
require_once dirname(dirname(__FILE__)) . '/BaseController.php';
require_once dirname(dirname(dirname(__FILE__))) . '/Log/Log.php';
require_once dirname(dirname(dirname(__FILE__))) . '/Model/LogModel.php';
//use Core\Controller\BaseController;
//use Core\DB;

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/26
 * Time: 11:30
 */
class TempController extends BaseController
{
    public function index()
    {
        // clear session on every reload
        session_start();
        $_SESSION = array();
//        var_dump($_SESSION);
        session_destroy();

        $this->smarty->display($this->tplDir . 'temp/index.php');
    }

    public function refresh()
    {
//        echo 100000000000 % 2;
//        echo 100 % 3;
//        echo $GLOBALS['parameters']['t'];
//        echo $GLOBALS['parameters']['t']/5;
//        echo is_integer($GLOBALS['parameters']['t']/5);
//        echo $GLOBALS['parameters']['t'];
//        echo intval($GLOBALS['parameters']['t']);
//        echo (($GLOBALS['parameters']['t'] / 2 % 10) == 7);

//        date_default_timezone_set('UTC');

//        $params = $GLOBALS['request']->parameters();
//        $time = $params['t'];
        session_start();

//        session_unset()
//        session_destroy(e);

        $addtime = time();
//        echo $addtime."<br/>";

        @$times=$_SESSION['lastTime'];
//        echo $times;
        if(!$times) {
            $times = 0;
        }

//        echo "addtime:" . $addtime;
//        echo "times:" . $times;
//        $dateTime = date('Y-m-d G:i:s', $time);
//        echo $dateTime;
//        $mill = $dateTime->getTimestamp();
        $db = new DB("mysql");
//        $db->prepare("select * from t_temp")->execute();
        $db->prepare("select * from t_temp where addtime > $times")->execute();
        $result = $db->fetchAll();
        echo json_encode($result);
//        echo $result;
        $_SESSION['lastTime'] = $addtime;

//        if ($GLOBALS['request']['parameters']['t'] % 2 != '0') {
//            $dateTime = new DateTime();
//            echo "new content {$dateTime->getTimestamp()}";
//        }


        /*echo '[
                {"title":"title1", "content":"content1"},
                {"title":"title2", "content":"content2"},
                {"title":"title3", "content":"content3"}
            ]';*/
    }

    public function bootstrap()
    {
        $this->smarty->display($this->tplDir . "temp/bootstrap.php");
    }

    public function log2File()
    {
        echo "begin";
        Log::info("[DAYL]", '这是一条记录');
        echo "end";
    }

    public function log2db()
    {
        echo "begin";
        $model = new LogModel();
        $model->user_id = 1;
        $model->action = "用于执行了一个操作";
        Log::logModel($model);
        echo "end";
    }
}