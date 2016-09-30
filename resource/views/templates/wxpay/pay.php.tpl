<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>微信支付页面</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
    {*<script type="text/javascript" src="Public/js/jquery.min.js"></script>*}
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript">
        $(function () {
            wx.config({
                debug: true,
                appId: '{$signPackage["appId"]}',
                timestamp: {$signPackage["timestamp"]},
                nonceStr: '{$signPackage["nonceStr"]}',
                signature: '{$signPackage["signature"]}',
                jsApiList: [
                    "chooseWXPay"  //支付
                ] // 所有要调用的 API 都要加到这个列表中
            });
            $('#aaa').on('click', function () {
                wx.ready(function () { // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
                    wx.chooseWXPay({
                        appId: '{$da['appId']}',
                        timestamp: '{$da['timeStamp']}', // 支付签名时间戳，注意微信jssdk中的所有使用timestamp字段均为小写。但最新版的支付后台生成签名使用的timeStamp字段名需大写其中的S字符
                        nonceStr: '{$da['nonceStr']}', // 支付签名随机串，不长于 32 位
                        package: '{$da['package']}', // 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=***）
                        signType: 'MD5', // 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
                        paySign: '{$da['paySign']}', // 支付签名
                        success: function (res) {
                            // 支付成功后的回调函数
                            if (res.errMsg == "chooseWXPay:ok") {
                                //支付成功
                                alert('支付成功');
                            } else {
                                alert(res.errMsg);
                            }
                        },
                        cancel: function (res) {
                            //支付取消
                            alert('支付取消');
                        }
                    });
                });
            });
        });
    </script>
</head>
<body>
<a id="aaa" style="font-size: 20px;">贡献一下</a>
</body>
</html>