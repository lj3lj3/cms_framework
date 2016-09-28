<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>巅峰网络信息服务有限公司</title>
    {literal}
    <link rel="stylesheet" href="/css/admin/system.css" type="text/css" media="screen">
    <script type="text/javascript" src="/js/jquery.js"></script>
    <!-- 点击收缩左边菜单 开始 -->
    <script type="text/javascript" src="/js/admin/bwLayout.js"></script>
    <script type="text/javascript" src="/js/admin/bwMenu.js"></script>
    <!-- 点击收缩左边菜单 结束 -->
    <script type="text/javascript" src="/js/admin/layer.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(window).bwLayout();
            $("#menu dl").bwMenu();
            $("#map-system").addClass("class2");
            $("#map-system").click(function () {
                $("#menunav ul li").removeClass();
                $("#map-system").addClass("class2");

            });
            $("#map-shop").click(function () {
                $("#menunav ul li").removeClass();
                $("#map-shop").addClass("class2");
            });
            $("#map-cms").click(function () {
                $("#menunav ul li").removeClass();
                $("#map-cms").addClass("class2");
            });
            $("#map-circle").click(function () {

                $("#menunav ul li").removeClass();
                $("#map-circle").addClass("class2");
            });
            $("#map-microshop").click(function () {

                $("#menunav ul li").removeClass();
                $("#map-microshop").addClass("class2");
            });
            $("#map-mobile").click(function () {

                $("#menunav ul li").removeClass();
                $("#map-mobile").addClass("class2");
            });
        });
        function neumshow(name) {
            $("#left").remove();
            $("#menu").remove();
            $.ajax({
                type: 'GET',
                url: 'menu' + name + ".html",
                success: function (data) {
                    $(".leftnav").html(data);
                    $(window).bwLayout();
                    $("#menu dl").bwMenu();
                }
            });
        }
        ;
    </script>
    <script language="javascript" src="/js/admin/ie6.js"></script>
    <script>
        $(document).ready(function () {
            //eg.2
            $('#menu-2').menuToggle({
                'ctrlBtn': 'ctrl-btn-2',
                'speed': 30,
                'width': 400,
                'openText': '<img src="/images/admin/admin/2.png" onMouseOver="this.src=\'/images/admin/4.png\'" onMouseOut="this.src=\'/images/admin/2.png\'">',
                'closeText': '<img src="/images/admin/1.png" onMouseOver="this.src=\'/images/admin/3.png\'" onMouseOut="this.src=\'/images/admin/1.png\'">',
            });

        });
        (function ($) {
            $.fn.extend({
                'menuToggle': function (options) {
                    //self变量，用于函数内部调用插件参数
                    var self = this;
                    //默认参数
                    this._default = {
                        'ctrlBtn': null,            //关闭&展开按钮id
                        'speed': 30,            //展开速度
                        'width': 400,            //展开菜单宽度
                        'height': 400,            //展开菜单高度

                        'type': 'width'            //width表示按宽度伸展，height表示按高度伸展
                    };
                    //插件初始化函数
                    this.init = function (options) {
                        //配置参数格式有误则提示并返回
                        if (typeof options != 'object') {
                            self.error('Options is not object Error!');
                            return false;
                        }
                        if (typeof options.ctrlBtn == 'undefined') {
                            self.error('Options ctrlBtn should not be empty!');
                            return false;
                        }
                        //存储自定义参数
                        self._default.ctrlBtn = options.ctrlBtn;
                        if (typeof options.type != 'undefined')         self._default.type = options.type;
                        if (typeof options.width != 'undefined')     self._default.width = options.width;
                        if (typeof options.height != 'undefined')     self._default.height = options.height;
                        if (typeof options.speed != 'undefined')     self._default.speed = options.speed;
                        if (typeof options.openText != 'undefined')     self._default.openText = options.openText;
                        if (typeof options.closeText != 'undefined') self._default.closeText = options.closeText;


                    };
                    this.run = function () {
                        $("#" + self._default.ctrlBtn).click(function () {
                            if ($(this).hasClass('closed')) {        //有closed类，表示已关闭，现在展开
                                $(this).removeClass('closed').html(self._default.closeText);
                                $(self).show().animate(self._default.expandOpen, self._default.speed);
                            } else {
                                $(this).addClass('closed').html(self._default.openText);
                                $(self).animate(self._default.expandClose, self._default.speed, function () {
                                    $(this).hide();
                                });
                            }
                        });
                    };

                    //Init
                    this.init(options);
                    this.run();
                }
            });
        })(jQuery);
    </script>
    {/literal}
</head>
<body>

<!---------------   top   ---------------->
<div style="width: auto;" id="header">
    <div id="logo"><a href="http://www.zhcart.com/"><img src="/images/admin/logo.png"></a></div>
    <div id="menunav">
        <ul>
            <li id="map-system">工作台</li>
            <li id="map-shop">内容</li>
            <li id="map-cms">项目模块</li>
            <li id="map-circle">界面</li>
            <li id="map-microshop">系统</li>
            <li id="map-mobile">管理</li>
        </ul>
    </div>
    <div id="top_nav">
        <span style="color:#FFF">您好！ admin (超级管理员)</span>&nbsp;&nbsp;
        <a href="#" class="homelink"><span>网站首页</span></a>&nbsp;
        <a href="#" class="crearlink" target="main"><span>缓存管理</span></a>&nbsp;
        <a href="#" class="help"><span>使用手册</span></a>&nbsp;
        <a href="#" class="exit"><span>退出登录</span></a>
    </div>

    <div class="clear"></div>

</div>

<!---------------   main   ---------------->
<div id="main">
    <div id="menu-2" class="leftnav hide-menu">

        <!---------------   left 菜单   ---------------->
        <div id="left">
            <ul style="margin-top: 0px;">
                <li class=""><a href="javascript:void(0);" class="panel">管理面板</a></li>
                <li class=""><a href="javascript:void(0);" class="order">订单相关</a></li>
                <li class=""><a href="javascript:void(0);" class="product">商品相关</a></li>
                <li class=""><a href="javascript:void(0);" class="member">会员管理</a></li>
                <li class=""><a href="javascript:void(0);" class="extend">推广运营</a></li>
                <li class=""><a href="javascript:void(0);" class="allocation">系统配置</a></li>
                <li class=""><a href="javascript:void(0);" class="date">数据统计</a></li>
                <li class=""><a href="javascript:void(0);" class="commontool">常用工具</a></li>
            </ul>
        </div>
        <!---------------   left 二级菜单   ---------------->
        <div id="menu">
            <div class="menu_warp" id="menu_list">
                <!--这里的rel跟上面的那个class一一对应,位置顺序无关-->
                <h2 class="menu_title" id="menu_title">管理面板</h2>
                <!--快捷导航-->
                <dl style="display: block;" rel="panel">
                    <dt><a data_open="1" href="#" class="hover">快捷导航</a></dt>
                    <dd style="display: block;">
                        <a data_open="1" target="main" href="http://wwww.baidu.com" class="hover">面板主页</a>
                        <a data_open="0" target="main" href="#" class="">更新密码</a>
                        <a data_open="0" target="main" href="#" class="">自定义菜单</a>
                    </dd>
                </dl>
                <!--订单管理-->
                <dl rel="order">

                    <dt><a class="hover" href="#" data_open="1">订单管理</a></dt>
                    <dd style="display: block;">
                        <a class="" href="html/列表.html" target="main" data_open="1">订单列表</a>
                        <a href="html/index1.html" target="main" data_open="0">物流跟踪</a>
                    </dd>

                    <dt><a class="hover" href="#" data_open="1">单据管理</a></dt>
                    <dd style="display: block;">
                        <a href="#" target="main" data_open="0">收款单据</a>
                        <a href="#" target="main" data_open="0">退款单据</a>
                        <a href="#" target="main" data_open="0">发货单据</a>
                        <a href="#" target="main" data_open="0">退货单据</a>
                    </dd>

                </dl>
                <!--商品管理-->
                <dl rel="product">
                    <dt><a class="hover" href="#" data_open="1">商品管理</a></dt>

                    <dd style="display: block;">
                        <a class="" href="#" target="main" data_open="1">商品列表</a>
                        <a href="#" target="main" data_open="0">仓库管理</a>
                        <a href="#" target="main" data_open="0">分类管理</a>
                        <a href="#" target="main" data_open="0">类型管理</a>
                        <a href="#" target="main" data_open="0">属性管理</a>
                    </dd>
                </dl>
                <!--会员中心-->
                <dl rel="member">
                    <dt><a class="hover" href="#" data_open="1">会员中心</a></dt>
                    <dd style="display: block;">
                        <a class="" href="html/管理员管理.html" target="main" data_open="1">用户管理</a>
                        <a href="#" target="main" data_open="0">留言列表</a>
                        <a href="#" target="main" data_open="0">订阅列表</a>
                        <a href="#" target="main" data_open="0">评论列表</a>
                    </dd>

                    <dt><a href="#" data_open="0">相关设置</a></dt>
                    <dd>
                        <a href="#" target="main" data_open="0">用户组列表</a>
                        <a href="#" target="main" data_open="0">成长值规则列表</a>
                        <a href="#" target="main" data_open="0">会员积分设置</a>
                        <a href="#" target="main" data_open="0">优惠券赠送设置</a>
                    </dd>

                    <dt><a href="#" data_open="0">相关明细</a></dt>
                    <dd>
                        <a href="#" target="main" data_open="0">优惠券明细</a>
                        <a href="#" target="main" data_open="0">缺货登记列表</a>
                        <a href="#" target="main" data_open="0">积分明细</a>
                        <a href="#" target="main" data_open="0">成长值明细</a>
                        <a href="#" target="main" data_open="0">会员购物车</a>
                        <a href="#" target="main" data_open="0">会员收藏</a>
                    </dd>
                </dl>
                <!--促销活动-->
                <dl rel="extend">
                    <dt><a class="hover" href="#" data_open="1">促销活动</a></dt>
                    <dd style="display: block;">
                        <a href="#" target="main" data_open="0">优惠券列表</a>
                        <a class="" href="#" target="main" data_open="1">促销列表</a>
                        <a href="#" target="main" data_open="0">组合销售</a>
                        <a href="#" target="main" data_open="0">商品包邮</a>
                        <a href="#" target="main" data_open="0">运费险设置</a>
                        <a href="#" target="main" data_open="0">限时特价</a>
                    </dd>

                    <dt><a href="#" data_open="0">网站运营</a></dt>
                    <dd>
                        <a href="#" target="main" data_open="0">专题推广</a>
                        <a href="#" target="main" data_open="0">分类频道页</a>
                        <a href="#" target="main" data_open="0">搜索词拦截</a>
                    </dd>
                </dl>
                <!--基础配置-->
                <dl rel="allocation">
                    <dt><a href="#" data_open="0">基础配置</a></dt>
                    <dd>
                        <a href="#" target="main" data_open="1">网站设置</a>
                        <a href="#" target="main" data_open="0">站点语言</a>
                        <a href="#" target="main" data_open="0">模板装修</a>
                    </dd>
                    <dt><a href="#" data_open="0">权限管理</a></dt>
                    <dd>
                        <a href="#" target="main" data_open="0">角色管理</a>
                        <a href="#" target="main" data_open="0">菜单管理</a>
                    </dd>
                </dl>
                <!--基础统计-->
                <dl rel="date">
                    <dt><a class="hover" href="#" data_open="1">基础统计</a></dt>
                    <dd style="display: block;">
                        <a href="#" target="main" data_open="1">商品销量</a>
                        <a class="" href="#" target="main" data_open="0">订单报表</a>
                    </dd>
                </dl>
                <!--应用中心-->
                <dl rel="commontool">
                    <dt><a class="hover" href="#" data_open="1">应用中心</a></dt>
                    <dd style="display: block;">
                        <a class="hover" href="#" target="main" data_open="1">插件管理</a>
                        <a href="#" target="main" data_open="0">主题管理</a>
                    </dd>
                </dl>

            </div>
        </div>
        <div style="display: none;" class="main_menu_bar">
            <a class="menu_up" href="javascript:;"></a>
            <a class="menu_down" href="javascript:;"></a>
        </div>

    </div>

    <div id="content">
        <div id="ctrl-btn-2" class="ctrl-btn "><img src="/images/admin/1.png" onMouseOver="this.src='images/3.png'"
                                                    onMouseOut="this.src='images/1.png'"/></div>
        <iframe id="mainFrame" scrolling="auto" allowtransparency="true"
                style="border: medium none; overflow-x: hidden; " src="" name="main" width="100%" frameborder="false"
                height="auto"></iframe>
    </div>
</div>
<!---------------   top   ---------------->

</body>
</html>