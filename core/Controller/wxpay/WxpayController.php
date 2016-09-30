<?php
//namespace Core\Controller\Wxpay;
//use Core\Controller\BaseController;

require_once dirname(dirname(__FILE__)) . "/BaseController.php";

/**
 * Created by PhpStorm.
 * User: Daylemon
 * Date: 2016/9/27
 * Time: 11:45
 */
class WxpayController extends BaseController
{
    const FEE_DEFAULT = 1000;

    private $prePath;

    private $logPath;

    public function __construct()
    {
        parent::__construct();
        $this->prePath = dirname(dirname(dirname(dirname(__FILE__)))) . "/vendor/tencent/";
        $this->logPath = dirname(dirname(dirname(dirname(__FILE__)))) . "/storage/log/";
    }

    public function index()
    {
        $this->smarty->display($this->tplDir . "/wxpay/index.php.tpl");
    }

    public function dashang()
    {
//        echo "dashang";
//        $this->wxPay();
        $this->wxPayPub();
    }

    private function wxPay()
    {
        ini_set('date.timezone', 'Asia/Shanghai');
//error_reporting(E_ERROR);
//        $prePath = dirname(dirname(dirname(dirname(__DIR__)))) . "/vendor/tencent/WxpayAPI_php_v3/lib/";
        require_once $this->prePath . 'WxpayAPI_php_v3/lib/WxPay.Api.php';
//        require_once "../lib/WxPay.Api.php";
        require_once $this->prePath . 'WxpayAPI_php_v3/lib/WxPay.JsApiPay.php';
//        require_once "WxPay.JsApiPay.php";
//        require_once 'log.php';
        require_once $this->prePath . 'WxpayAPI_php_v3/lib/log.php';

        //初始化日志
        $logHandler = new CLogFileHandler($this->logPath . date('Y-m-d') . '.log');
        $log = Log::Init($logHandler, 15);

        //①、获取用户openid
        $tools = new JsApiPay();
        $openId = $tools->GetOpenid();

        //②、统一下单
        $input = new WxPayUnifiedOrder();
//        $input->SetAppid("gongzhonghao");
//        $input->SetMch_id("");
        $input->SetBody("微信端-打赏");  //*
//        $input->SetAttach("test");
        $input->SetOut_trade_no(WxPayConfig::MCHID . date("YmdHis"));    //*
        $params = $GLOBALS['request']->parameters();
        if (!isset($params['fee'])) {
            $params['fee'] = self::FEE_DEFAULT;
        }
        $input->SetTotal_fee($params['fee']);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        // Already set in the Config
//        $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
        $input->SetTrade_type("JSAPI");     //*
        $input->SetOpenid($openId);
        $order = WxPayApi::unifiedOrder($input);
        echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
        $this->printf_info($order);
        $jsApiParameters = $tools->GetJsApiParameters($order);

        //获取共享收货地址js函数参数
        $editAddress = $tools->GetEditAddressParameters();

        $this->displayPayPage($params['fee'], $jsApiParameters, $editAddress);
    }

    private function displayPayPage($fee, $jsApiParameters, $editAddress = '')
    {
        $this->smarty->assign('fee', $fee);
        // display
        $this->smarty->assign('jsApiParameters', $jsApiParameters);
        $this->smarty->assign('editAddress', $editAddress);

        $this->smarty->display($this->tplDir . 'wxpay/paypub.php.tpl');
    }

    public function payViewTest()
    {
        $this->smarty->assign('fee', 1111);
        // display
        $this->smarty->assign('jsApiParameters', array('key', 'value'));
        $this->smarty->assign('editAddress', array('key', 'value'));

        $this->smarty->display($this->tplDir . 'wxpay/paypub.php.tpl');
    }

    //打印输出数组信息
    private function printf_info($data)
    {
        foreach ($data as $key => $value) {
            echo "<font color='#00ff55;'>$key</font> : $value <br/>";
        }
    }

    public function notify()
    {
        $this->wxNotifyPub();
    }

    private function wxNotify()
    {
        ini_set('date.timezone', 'Asia/Shanghai');
        error_reporting(E_ERROR);

        require_once $this->prePath . 'WxpayAPI_php_v3/lib/WxPay.Api.php';
        require_once $this->prePath . 'WxpayAPI_php_v3/lib/WxPay.Notify.php';
        require_once $this->prePath . 'WxpayAPI_php_v3/lib/log.php';
        require_once 'PayNotifyCallBack.php';

        //初始化日志
        $logHandler = new CLogFileHandler($this->logPath . date('Y-m-d') . '.log');
        $log = Log::Init($logHandler, 15);

        Log::DEBUG("begin notify");
        $notify = new PayNotifyCallBack();
        $notify->Handle(false);
    }

    /**
     * JS_API支付demo
     * ====================================================
     * 在微信浏览器里面打开H5网页中执行JS调起支付。接口输入输出数据格式为JSON。
     * 成功调起支付需要三个步骤：
     * 步骤1：网页授权获取用户openid
     * 步骤2：使用统一支付接口，获取prepay_id
     * 步骤3：使用jsapi调起支付
     */
    private function wxPayPub()
    {
        include_once($this->prePath . "WxPayPubHelper/WxPayPubHelper.php");

        //使用jsapi接口
        $jsApi = new JsApi_pub();

        //=========步骤1：网页授权获取用户openid============
        //通过code获得openid
        if (!isset($_GET['code'])) {
            // Mod
            $baseUrl = urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
//            $baseUrl = urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']);
            echo $baseUrl;
            //触发微信返回code码
//            $url = $jsApi->createOauthUrlForCode(WxPayConf_pub::JS_API_CALL_URL);
            $url = $jsApi->createOauthUrlForCode($baseUrl);
            Header("Location: $url");
        } else {
            //获取code码，以获取openid
            $code = $_GET['code'];
            $jsApi->setCode($code);
            $openid = $jsApi->getOpenId();
        }

        //=========步骤2：使用统一支付接口，获取prepay_id============
        //使用统一支付接口
        $unifiedOrder = new UnifiedOrder_pub();

        //设置统一支付接口参数
        //设置必填参数
        //appid已填,商户无需重复填写
        //mch_id已填,商户无需重复填写
        //noncestr已填,商户无需重复填写
        //spbill_create_ip已填,商户无需重复填写
        //sign已填,商户无需重复填写
        $unifiedOrder->setParameter("openid", "$openid");//商品描述
        $unifiedOrder->setParameter("body", "贡献一分钱");//商品描述
        //自定义订单号，此处仅作举例
        $timeStamp = time();
//        $out_trade_no = WxPayConf_pub::APPID . "$timeStamp";
        $out_trade_no = WxPayConf_pub::MCHID . "$timeStamp";
        $unifiedOrder->setParameter("out_trade_no", "$out_trade_no");//商户订单号
        $params = $GLOBALS['request']->parameters();
        if (!isset($params['fee'])) {
            $params['fee'] = self::FEE_DEFAULT;
        }
        $unifiedOrder->setParameter("total_fee", $params['fee']);//总金额
//        $unifiedOrder->setParameter("total_fee", "1");//总金额
        $unifiedOrder->setParameter("notify_url", WxPayConf_pub::NOTIFY_URL);//通知地址
        $unifiedOrder->setParameter("trade_type", "JSAPI");//交易类型
        //非必填参数，商户可根据实际情况选填
        //$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
        //$unifiedOrder->setParameter("device_info","XXXX");//设备号
        //$unifiedOrder->setParameter("attach","XXXX");//附加数据
        //$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
        //$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
        //$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记
        //$unifiedOrder->setParameter("openid","XXXX");//用户标识
        //$unifiedOrder->setParameter("product_id","XXXX");//商品ID

        $prepay_id = $unifiedOrder->getPrepayId();
        //=========步骤3：使用jsapi调起支付============
        $jsApi->setPrepayId($prepay_id);

        $jsApiParameters = $jsApi->getParameters();
        //echo $jsApiParameters;

        // Display
        $this->displayPayPage($params['fee'], $jsApiParameters);
    }

    private function wxNotifyPub()
    {
        /**
         * ====================================================
         * 支付完成后，微信会把相关支付和用户信息发送到商户设定的通知URL，
         * 商户接收回调信息后，根据需要设定相应的处理流程。
         *
         * 这里举例使用log文件形式记录回调信息。
         */
        include_once($this->prePath . "WxPayPubHelper/log_.php");
        include_once($this->prePath . "WxPayPubHelper/WxPayPubHelper.php");

        //使用通用通知接口
        $notify = new Notify_pub();

        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);

        //验证签名，并回应微信。
        //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
        //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
        //尽可能提高通知的成功率，但微信不保证通知最终能成功。
        if ($notify->checkSign() == FALSE) {
            $notify->setReturnParameter("return_code", "FAIL");//返回状态码
            $notify->setReturnParameter("return_msg", "签名失败");//返回信息
        } else {
            $notify->setReturnParameter("return_code", "SUCCESS");//设置返回码
        }
        $returnXml = $notify->returnXml();
        echo $returnXml;

        $this->saveDate($notify->getData());

        //==商户根据实际情况设置相应的处理流程，此处仅作举例=======

        //以log文件形式记录回调信息
        $log_ = new Log_();
        $log_name = $this->logPath . "notify_url.log";//log文件路径
        $log_->log_result($log_name, "【接收到的notify通知】:\n" . $xml . "\n");

        if ($notify->checkSign() == TRUE) {
            if ($notify->data["return_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                $log_->log_result($log_name, "【通信出错】:\n" . $xml . "\n");
            } elseif ($notify->data["result_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                $log_->log_result($log_name, "【业务出错】:\n" . $xml . "\n");
            } else {
                //此处应该更新一下订单状态，商户自行增删操作
                $log_->log_result($log_name, "【支付成功】:\n" . $xml . "\n");
            }

            //商户自行增加处理流程,
            //例如：更新订单状态
            //例如：数据库操作
            //例如：推送支付完成信息
        }
    }

    private function saveDate($data)
    {
        require_once dirname(dirname(dirname(__FILE__))) . '/Model/WxpayResult.php';

        return WxpayResult::newInstance()->insert($data);
    }

    public function saveDataTest()
    {
        require_once dirname(dirname(dirname(__FILE__))) . '/Model/WxpayResult.php';
        $keyAndValue = array(
            WxpayResult::C_OUT_TRADE_NO => '1409811660',
            WxpayResult::C_RETURN_CODE => 'SUCCESS',
//            WxpayResult::C_RETURN_MSG => ,
            WxpayResult::C_DEVICE_INFO => 'ksjdlkfjksd',
            WxpayResult::C_RESULT_CODE => 'SUCCESS',
//            WxpayResult::C_ERR_CODE => $data[WxpayResult::C_ERR_CODE],
            WxpayResult::C_OPENID => 'oUpF8uMEb4qRXf22hE3X68TekukE',
            WxpayResult::C_TOTAL_FEE => 1200,
            WxpayResult::C_TRANSACTION_ID => '1004400740201409030005092168',
//            WxpayResult::C_TIME_END => '20140903131540',
        );

        return $this->saveDate($keyAndValue);
    }
}