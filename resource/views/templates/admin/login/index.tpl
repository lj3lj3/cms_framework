<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0043)http://qjwm.dianfengcms.com/admin/login.php -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>欢迎登录DFCMS-网站管理系统</title>

    <link href="/css/admin/login/style.css" rel="stylesheet" type="text/css">
    <script src="http://lib.sinaapp.com/js/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
    <script src="/js/admin/login/cloud.js" type="text/javascript"></script>
    {literal}
        <script language="javascript">
            $(function () {
                $('.loginbox').css({'position': 'absolute', 'left': ($(window).width() - 692) / 2});
                $(window).resize(function () {
                    $('.loginbox').css({'position': 'absolute', 'left': ($(window).width() - 692) / 2});
                })
            });
            function login(ok) {
                var adminname = ok.adminname.value;//验证用户名
                if (adminname == "" || adminname == "用户名") {
                    texts = "用户名不能为空!"
                    alert(texts);
                    ok.adminname.focus();
                    return false;
                }
                var password = ok.password.value;//验证密码
                if (password == "" || password == "dianfeng") {
                    texts = "密码不能为空!"
                    alert(texts);
                    ok.password.focus();
                    return false;
                }
                // Remove this
                //ok.action = "?action=1";
                ok.submit();
            }
        </script>
    {/literal}
</head>

<body style="background-color: rgb(28, 119, 172); background-image: url(&quot;images/light.png&quot;); background-repeat: no-repeat; background-position: -808.7px 0px; overflow: hidden;">
<div id="mainBody">
    <div id="cloud1" class="cloud" style="background-position: 847.8px 100px;"></div>
    <div id="cloud2" class="cloud" style="background-position: 651px 460px;"></div>
</div>
<div class="logintop">
    <span>欢迎登录DFCMS-网站管理系统</span>
    <ul>
        <li><a href="http://qjwm.dianfengcms.com/admin/login.php#">回首页</a></li>
        <li><a href="http://qjwm.dianfengcms.com/admin/login.php#">帮助</a></li>
        <li><a href="http://qjwm.dianfengcms.com/admin/login.php#">关于</a></li>
    </ul>
</div>
<div class="loginbody">
    <span class="systemlogo"></span>
    <div class="loginbox" style="position: absolute; left: 614px;">
        <ul>
            <form name="formlogin" method="post" action="/admin/doLogin">
                <input type="hidden" name="originator" value="140640">
                <li><input name="adminname" type="text" class="loginuser"
                           onblur="{literal}if(this.value==&#39;&#39;){this.value=&#39;请输入用户名&#39;}{/literal}"
                           onfocus="{literal}if(this.value==&#39;请输入用户名&#39;){this.value=&#39;&#39;}{/literal}"
                           value="请输入用户名"
                           oldvalue="请输入用户名"></li>
                <li><input name="password" type="password" class="loginpwd"
                           onblur="{literal}if(this.value==&#39;&#39;){this.value=&#39;请输入密码&#39;}{/literal}"
                           onfocus="{literal}if(this.value==&#39;请输入密码&#39;){this.value=&#39;&#39;}{/literal}"
                           value="请输入密码"
                           oldvalue="请输入密码"></li>
                <li><input name="loginBtn" type="button" class="loginbtn" value="登录"
                           onclick="login(document.formlogin)"><label><input name="" type="checkbox" value=""
                                                                             checked="checked">记住密码</label><label><a
                                href="http://qjwm.dianfengcms.com/admin/login.php#">忘记密码？</a></label></li>
            </form>
        </ul>
    </div>
</div>
<div class="loginbm">CopyRight 2013-2015 榆林市巅峰网络信息服务有限公司 登记号：2015SR101053 <a href="http://www.dianfengcms.com/">DIANFENGCMS</a>
    TEAM
</div>
</body>
</html>