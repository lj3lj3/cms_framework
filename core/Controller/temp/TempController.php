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

        @$times = $_SESSION['lastTime'];
//        echo $times;
        if (!$times) {
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

    public function load()
    {
        header("Access-Control-Allow-Origin: *");
        echo '[
                {"headpic": "http://127.0.0.1/images/admin/allocation_dark.png", "title":"title1", "content":"content1", 
                "time":"2019-05-22 15:10", "id":20},
                {"headpic": "http://127.0.0.1/images/admin/date_dark.png", "title":"title2", "content":"content2", 
                "time":"2019-05-22 15:10", "id":30},
                {"headpic": "http://127.0.0.1/images/admin/logo.png", "title":"title3", "content":"content3", 
                "time":"2019-05-22 15:10", "id":40}
            ]';
    }

    public function live()
    {
        $params = $GLOBALS['request']->parameters();
        header("Access-Control-Allow-Origin: *");

        if(isset($params['c']) && $params['c'] == 1){
            echo '[{"time":"2016-10-24 12:10", "pic":"http://zhibo.yesky.com/images/2015481410211428473421712580x400.jpg","content":"4月8日，美图手机将在北京竞园举行一个颜值挺高的发布会。"}]';
        } else {
            echo '[{"time":"2016-10-24 12:10", "pic":"http://zhibo.yesky.com/images/2015481410211428473421712580x400.jpg","content":"4月8日，美图手机将在北京竞园举行一个颜值挺高的发布会。"},{"time":"2016-10-24 12:30", "pic":"http://zhibo.yesky.com/images/201548146121428473172470580x400.jpg","content":"美图公司就把发布会做成了一个时尚大趴，邀请了林志颖、黄一琳等众多高颜值明星出席。而今年作为美图“首席颜值官”暨美图手机新品参与设计师——Angelababy将率众女神降临发布会现场，并且还有明星红毯走秀。这一次能够近距离“女神”，光想想就有点小激动啊。"},{"time":"2016-10-24 13:10", "pic":"http://zhibo.yesky.com/images/2015481429281428474568943580x400.jpg","content":"现场外围布置已经妥当，随处可见的“meitu”烘托着盛筵氛围。"}]';
        }
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

    public function wenming()
    {
        require_once dirname(dirname(dirname(__FILE__))) . '/VO/Common/DivTitle.php';
        require_once dirname(dirname(dirname(__FILE__))) . '/VO/Common/ArticleList.php';

        $data = array();

        //要闻标题
        $divTitle = new DivTitle();
        $divTitle->left_title = "要闻";
        $divTitle->add2right("要闻", "http://yl.wenming.cn/jrtj/");
        $data['yaowen']['divTitle'] = $divTitle->toArray();

        $yaowenList = new ArticleList();
        $yaowenList->add2List("世纪广场举行经典文艺节目展演", "http://yl.wenming.cn/jrtj/201610/t20161026_2899480.shtml");
        $yaowenList->add2List("9-10月的“陕西好人”榜单出炉 榆林有两人上榜", "http://yl.wenming.cn/jrtj/201610/t20161026_2898698.shtml");
        $yaowenList->add2List("榆林民俗博物馆进校园 助力“十一艺术节”", "http://yl.wenming.cn/jrtj/201610/t20161025_2896139.shtml");
        $yaowenList->add2List("榆林市举行陕北民歌大赛决赛", "http://yl.wenming.cn/jrtj/201610/t20161025_2896096.shtml");
        $yaowenList->add2List("榆林：补短板促发展 打造宜居之城", "http://yl.wenming.cn/jrtj/201610/t20161025_2896068.shtml");
        $data['yaowen']['linkList'] = $yaowenList->toArray();

        $this->smarty->assign("data", $data);
        $this->smarty->display($this->tplDir . "temp/wenming.tpl");
    }

    public function article()
    {
        require_once dirname(dirname(dirname(__FILE__))) . '/VO/Common/DivTitle.php';
        require_once dirname(dirname(dirname(__FILE__))) . '/Model/Article.php';

        $divTitle = new DivTitle();
        $divTitle->left_title = "要闻";
        $divTitle->add2right("首页", "http://yl.wenming.cn/");
        $divTitle->add2right("要闻", "http://yl.wenming.cn/jrtj/");
        $data['divTitle'] = $divTitle->toArray();

        /**
         * @var $articleArray array
         */
        $articleArray = Article::newInstance(599)->queryWithContent();
        // 转换时间
        $articleArray[0]['inputtime'] = date("Y-m-d H:i:s", $articleArray[0]['inputtime']);

        $data['article'] = $articleArray[0];

        $this->smarty->assign("data", $data);
        $this->smarty->display($this->tplDir . "temp/article.tpl");
    }
}