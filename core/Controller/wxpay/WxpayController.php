<?php
namespace Core\Controller\Wxpay;
use Core\Controller\BaseController;

require_once dirname(__DIR__) . "/BaseController.php";

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/27
 * Time: 11:45
 */
class WxpayController extends BaseController
{
    private $prePath;

    private $logPath;

    public function __construct()
    {
        parent::__construct();
        $this->prePath = dirname(dirname(dirname(__DIR__))) . "/vendor/tencent/WxpayAPI_php_v3/lib/";
        $this->logPath = dirname(dirname(dirname(__DIR__))) . "/storage/log/";
    }

    public function index()
    {
        $this->smarty->display($this->tplDir . "/wxpay/index.php.tpl");
    }

    public function dashang()
    {
        echo "dashang";
        $this->wxPay();
    }

    private function wxPay()
    {
        ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
//        $prePath = dirname(dirname(dirname(dirname(__DIR__)))) . "/vendor/tencent/WxpayAPI_php_v3/lib/";
        require_once $this->prePath . 'WxPay.Api.php';
//        require_once "../lib/WxPay.Api.php";
        require_once $this->prePath . 'WxPay.JsApiPay.php';
//        require_once "WxPay.JsApiPay.php";
//        require_once 'log.php';
        require_once $this->prePath . 'log.php';

        //初始化日志
        $logHandler= new \CLogFileHandler($this->logPath . date('Y-m-d').'.log');
        $log = \Log::Init($logHandler, 15);

        //①、获取用户openid
        $tools = new \JsApiPay();
        $openId = $tools->GetOpenid();

        //②、统一下单
        $input = new \WxPayUnifiedOrder();
//        $input->SetAppid("gongzhonghao");
//        $input->SetMch_id("");
        $input->SetBody("微信端-打赏");  //*
        $input->SetAttach("test");
        $input->SetOut_trade_no(\WxPayConfig::MCHID.date("YmdHis"));    //*
        $input->SetTotal_fee("1000");   //*10元
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        // Already set in the Config
//        $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
        $input->SetTrade_type("JSAPI");     //*
        $input->SetOpenid($openId);
        $order = \WxPayApi::unifiedOrder($input);
        echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
        $this->printf_info($order);
        $jsApiParameters = $tools->GetJsApiParameters($order);

        //获取共享收货地址js函数参数
        $editAddress = $tools->GetEditAddressParameters();

        // display
        $this->smarty->assign('jsApiParameters', $jsApiParameters);
        $this->smarty->assign('editAddress', $editAddress);

        $this->smarty->display($this->tplDir . 'wxpay/pay.php.tpl');
    }

    //打印输出数组信息
    private function printf_info($data)
    {
        foreach($data as $key=>$value){
            echo "<font color='#00ff55;'>$key</font> : $value <br/>";
        }
    }

    public function notify()
    {
        ini_set('date.timezone','Asia/Shanghai');
        error_reporting(E_ERROR);

        require_once $this->prePath . 'WxPay.Api.php';
        require_once $this->prePath . 'WxPay.Notify.php';
        require_once $this->prePath . 'log.php';
        require_once 'PayNotifyCallBack.php';

        //初始化日志
        $logHandler= new \CLogFileHandler($this->logPath . date('Y-m-d').'.log');
        $log = \Log::Init($logHandler, 15);

        \Log::DEBUG("begin notify");
        $notify = new \PayNotifyCallBack();
        $notify->Handle(false);
    }
}