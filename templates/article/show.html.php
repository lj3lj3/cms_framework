<?php defined('IN_CMS') or exit('No direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo $data['article']['title'];?></title>

    <meta name="filetype" content="0">
    <meta name="publishedtype" content="1">
    <meta name="pagetype" content="1">
    <meta name="catalogs" content="sub_7723">
    <meta name="contentid" content="2899480">
    <meta name="publishdate" content="2016-10-26">
    <meta name="author" content="美编">
    <meta name="source" content="榆林文明网">

    <link rel="stylesheet" type="text/css" href="/css/temp/index2016-007.css">
    <link rel="stylesheet" type="text/css" href="/css/common/divtitle.css">
    <script language="javascript" type="text/javascript" src="/js/temp/jquery.pack.js"></script><script type="text/javascript" src="/js/temp/jquery.SuperSlide.2.1.1.js"></script><script type="text/javascript" src="/js/temp/banner.js"></script><script type="text/javascript" src="/js/temp/tab.js"></script><script>
        $(function(){
            $(".indexShowBox").slideJ({
                leftBtn:".indexShowLeft",
                rightBtn:".indexShowRight",
                speed:800
            });
        });
    </script></head>


<!----------------------我们的节日 js--->

<!----------------------切换 js--->


<body>
<div class="header">
    <!--  top  -->
    <div class="top">
        <dl>
            <dt><a href="http://www.wenming.cn" target="_blank">中国文明网总站</a></dt>
            <dd><a href="/xqdt/yy/">榆阳</a>|<a href="/xqdt/hs/">横山</a>|<a href="/xqdt/jb/">靖边</a>|<a href="/xqdt/db/">定边</a>|<a href="/xqdt/sm/">神木</a>|<a href="/xqdt/fg/">府谷</a>|<a href="/xqdt/mz/">米脂</a>|<a href="/xqdt/zz/">子洲</a>|<a href="/xqdt/sd/">绥德</a>|<a href="/xqdt/jx/">佳县</a>|<a href="/xqdt/wb/">吴堡</a>|<a href="/xqdt/qj/">清涧</a></dd>
        </dl>
    </div>
    <!--  logo区  -->
    <div class="logo">
        <div class="logoleft">
            <dl>
                <dt><a href="http://yl.wenming.cn"><img src="/images/temp/logo.jpg"></a></dt>
                <dd id="time">10/26/2016, 5:10:22 PM 星期三</dd>
            </dl>
        </div>

        <div class="advbox"><a href="http://www.wenming.cn/sbhr_pd/hr365/" target="_blank"><img src="/images/temp/W020160204584734749346.jpg"></a></div>

        <div class="clear"></div>
    </div>
    <!--  导航  -->
    <div class="navBox">
        <dl>
            <dt><a href="http://yl.wenming.cn">网站首页</a></dt>
            <dd>
                <ul>
                    <li><a href="/gggs/">公示公告</a></li>
                    <li><a href="/wmbb/">文明播报</a></li>
                    <li><a href="/ycpl/">原创评论</a></li>
                    <li><a href="/xqdt/">县区动态</a></li>
                    <div class="clear"></div>
                </ul>
            </dd>
            <dd>
                <ul>
                    <li><a href="/zthd/">主题活动</a></li>
                    <li><a href="/zyfw/">志愿服务</a></li>
                    <li><a href="/wmcj/">文明创建</a></li>
                    <li><a href="/sxyl/">书香榆林</a></li>
                    <div class="clear"></div>
                </ul>
            </dd>
            <dd>
                <ul>
                    <li><a href="/ddmf/">道德模范</a></li>
                    <li><a href="/sbhr/">身边好人</a></li>
                    <li><a href="/wcnr/">未成年人</a></li>
                    <li><a href="/wmbg/">文明曝光</a></li>
                    <div class="clear"></div>
                </ul>
            </dd>
            <dd>
                <ul>
                    <li><a href="/mlxc/">美丽乡村</a></li>
                    <li><a href="/zlxz/">文明下载</a></li>
                    <li><a href="/zxsp/">视频影像</a></li>
                    <li><a href="/wmdjr/">我们的节日</a></li>
                    <div class="clear"></div>
                </ul>
            </dd>
            <div class="clear"></div>
        </dl>
    </div>
</div>




<div class="main">
    <!--  公共部分  -->
    <div class="conter artical">
        <!-- 文章列表 -->
        <div class="artleft artshow">
            <?php defined('IN_CMS') or exit('No direct script access allowed'); ?>
<div class="divTitle">
    <span>
        <img id="divTitleImg" src="<?php echo $data['divTitle']['img'];?>">
        <a href="<?php echo $data['divTitle']['left_link'];?>"><?php echo $data['divTitle']['left_title'];?></a>
        <label>
            <?php $index=0?>
            <?php $n=1; if(is_array($data['divTitle']['right'])) foreach($data['divTitle']['right'] AS $innerTitle => $link) { ?>
                <?php $index = $index + 1?>
                <a href="<?php echo $link;?>" target="_blank" title="<?php echo $innerTitle;?>" class="CurrChnlCls"><?php echo $innerTitle;?></a>
                <?php if($index < count($data['divTitle']['right'])) { ?>
                    &nbsp;&gt;&nbsp;
                <?php } ?>
            <?php $n++;}?>
            <!--{*<a href="../../" target="_blank" title="首页" class="CurrChnlCls">首页</a>
            &nbsp;&gt;&nbsp;
            <a href="../" target="_blank" title="书香榆林" class="CurrChnlCls">书香榆林</a>*}-->
        </label>
    </span>
</div>
            <div class="artbox">
                <?php defined('IN_CMS') or exit('No direct script access allowed'); ?>
<div class="artbox">
    <h3><?php echo $data['article']['title'];?></h3>
    <div class="function_tex"><label>发布时间：<?php echo $data['article']['updatetime'];?></label><label>来源：<?php echo $data['article']['copyfrom'];?></label><label
    >责任编辑：<?php echo $data['article']['author'];?></label></div>
    <div id="content" class="content">
        <?php echo $data['article']['content'];?>
    </div>
</div>
            </div>
        </div>
        <div class="clear"></div>
    </div>

</div>










<div id="bottom">
    <div id="footer">
        <ol>
            <div class="hr_10"></div>
            <li>中共榆林市委宣传部 榆林市创文办 榆林市文明办 主办</li>
            <li>联系电话：0912-8153456 8154567 电子邮箱：wmb3283858@163.com</li>
            <li><a href="http://www.miibeian.gov.cn/" target="_blank">京ICP备10031449号</a>&nbsp;&nbsp;互联网新闻信息服务许可证号 1012010003</li>
        </ol>
    </div>
</div>
<div style="display:none">
    <script type="text/javascript">document.write(unescape("%3Cscript src='http://202.123.107.15/webdig.js?z=11' type='text/javascript'%3E%3C/script%3E"));</script><script src="http://202.123.107.15/webdig.js?z=11" type="text/javascript"></script>
    <script type="text/javascript">wd_paramtracker("_wdxid=000000000000000000000000000000000000000000")</script>
    <script src="http://s4.cnzz.com/stat.php?id=5427390&amp;web_id=5427390" language="JavaScript"></script><script src="http://c.cnzz.com/core.php?web_id=5427390&amp;t=z" charset="utf-8" type="text/javascript"></script><a href="http://www.cnzz.com/stat/website.php?web_id=5427390" target="_blank" title="站长统计">站长统计</a></div>

</body></html>