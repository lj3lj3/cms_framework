<?php defined('IN_CMS') or exit('No direct script access allowed'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>DFCMS-网站管理系统</title>
    <link href="/css/admin/style.css" rel="stylesheet" type="text/css">
    <link href="/css/admin/select.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        a.close-own {
            background: url(/images/admin/cross.png) no-repeat left 3px;
            display: block;
            width: 16px;
            height: 16px;
            position: absolute;
            outline: none;
            right: 7px;
            top: 8px;
            text-indent: 200px;
            overflow: hidden
        }

        a.close-own:hover {
            background-position: left -46px
        }
    </style>
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/admin/popup.js"></script>
    <script type="text/javascript" src="/js/admin/js.js"></script>
    <script type="text/javascript" src="/js/admin/select-ui_min.js"></script>
    <script type="text/javascript" src="/js/admin/colorpicker.js"></script>
    <!-- 配置文件 -->
    <script type="text/javascript" src="/other/ueditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/other/ueditor/ueditor.all.js"></script>
        <script type="text/javascript">
            $(document).ready(function (e) {
                $(".select1").uedSelect({
                    width: 160
                });
                $(".select2").uedSelect({
                    width: 260
                });
            });
            function input_ok(ok) {
                var text = "";
                var M1 = ok.title.value;
                if (M1 == "") {
                    text = text + "[内容标题] 不能为空；\n"
                }
                var M2 = ok.author.value;
                if (M2 == "") {
                    text = text + "[拟　　稿] 不能为空；\n"
                }
                var M3 = ok.verifier.value;
                if (M3 == "") {
                    text = text + "[审　　核] 不能为空；\n"
                }
                var M4 = ok.qianfa.value;
                if (M4 == "") {
                    text = text + "[签　　发] 不能为空；\n"
                }

                //向页面反馈信息
                if (text == "") {
                    ok.action = "store";
                    ok.submit();
                } else {
                    alert("出错提示：\n\n" + text);
                    return false;
                }
            }
        </script>
    <script src="/other/ueditor/lang/zh-cn/zh-cn.js" type="text/javascript"
            defer="defer"></script>
    <link href="/other/ueditor/themes/default/css/ueditor.css" type="text/css"
          rel="stylesheet">
    <script src="/other/ueditor/third-party/codemirror/codemirror.js" type="text/javascript"
            defer="defer"></script>
    <link rel="stylesheet" type="text/css"
          href="/other/ueditor/third-party/codemirror/codemirror.css">
    <script src="/other/ueditor/third-party/zeroclipboard/ZeroClipboard.js"
            type="text/javascript" defer="defer"></script>
</head>

<body>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li>首页</li>
        <li>内容管理</li>
        <li>公示公告</li>
    </ul>
</div>

<div class="formbody">

    <div class="formtitle"><span>内容添加</span></div>
    <form name="myform" method="post">
        <input type="hidden" name="catid" value="1">
        <input type="hidden" name="originator" value="387198">
        <input name="sourceurl" type="hidden" id="sourceurl"
               value="http://qjwm.dianfengcms.com/admin/news/list.php?catid=1">
        <input type="hidden" name="style_color" id="style_color" value="">
        <input type="hidden" name="style_font_weight" id="style_font_weight" value="">
        <ul class="forminfo">
            <li><label>所属专题</label>
                <div class="vocation">
                    <div class="uew-select">
                        <div class="uew-select-value ue-state-default" style="width: 233px;"><em
                                    class="uew-select-text">不属专题稿件</em><em class="uew-icon uew-icon-triangle-1-s"></em>
                        </div>
                        <select name="special" class="select2" id="special" style="width: 260px;">
                            <option value="0">不属专题稿件</option>
                        </select></div>
                </div>
            </li>
            <li><label>内容标题<b>*</b></label><input name="title" type="text" class="dfinput" id="title"
                                                  style="width:450px;" onkeyup="checkLen(this, 'title_len', 40);"
                                                  maxlength="40">
                <i style="position:relative;"><img src="/images/admin/colour.png" width="10" height="10"
                                                   onclick="colorpicker('title_colorpanel','set_title_color');"
                                                   style="cursor:hand;">
                    <div class="title_color colorpanel" id="title_colorpanel"
                         style="position:absolute; top:30px; left:0px;"></div>
                    <img src="/images/admin/bold.png" width="10" height="10" onclick="input_font_bold()"
                         style="cursor:hand"></i>
                <i>还可输入<b><span style="display:inline;" id="title_len">40</span></b> 个字符</i></li>
            <li><label>拟　　稿<b>*</b></label><input name="author" type="text" class="dfinput" id="author"
                                                  style="width:150px;"><i></i></li>
            <li><label>审　　核<b>*</b></label><input name="verifier" type="text" class="dfinput" id="verifier"
                                                  style="width:150px;"><i></i></li>
            <li><label>签　　发<b>*</b></label><input name="qianfa" type="text" class="dfinput" id="qianfa"
                                                  style="width:150px;"><i></i></li>
            <li><label>内容来源<b>*</b></label><input name="copyfrom" type="text" class="dfinput" id="copyfrom"
                                                  style="width:200px;" value=""><i></i></li>
            <li><label>标题图片<b> </b></label><input name="thumb" type="text" class="dfinput" id="thumb"
                                                  style="width:220px;float:left;"><i><a class="sc"
                                                                                        onclick="javascript:ShowIframe('标题图片上传','../upload.php?pic=thumb','340','80')">上传</a></i>
            </li>
            <li><label>内容摘要<b> </b></label><textarea name="description" cols="" rows="" class="textinput"
                                                     id="description" style="height:60px;"></textarea></li>
            <li><label>内　　容<b> </b></label>
                <div class="ueditors">
                    <script id="content" name="content" type="text/plain"></script>
                    <!-- 实例化编辑器 -->
                    <script type="text/javascript">
                        var ue = UE.getEditor('content');
                    </script>
                </div>
            </li>
            <li><label>自动获取<b> </b></label><input name="add_introduce" type="checkbox" value="1" checked="">是否截取内容<input
                        name="introcude_length" type="text" class="dfinput" id="introcude_length" style="width:40px;"
                        value="200">字符至内容摘要&nbsp;&nbsp; <input type="checkbox" name="auto_thumb" value="1">
                是否获取内容第<input name="auto_thumb_no" type="text" class="dfinput" id="auto_thumb_no" style="width:30px;"
                              value="1">张图片作为标题图片
            </li>
            <li><label>链接地址<b> </b></label><input name="url" type="text" class="dfinput" id="url" style="width:350px;"
                                                  value="">
                <i><input name="islink" type="checkbox" id="islink" value="1"> <font color="red">转向链接</font></i></li>
            <li><label>推 荐 位<b> </b></label><cite>
                    <input name="posids[]" type="checkbox" id="posids" value="2">头条要闻 &nbsp;&nbsp;
                    <input name="posids[]" type="checkbox" id="posids" value="1">首页幻灯 &nbsp;&nbsp;
                </cite>
            </li>


            <li><label>是否发布</label><cite><input name="status" type="radio" value="99" checked="checked">是&nbsp;&nbsp;&nbsp;&nbsp;<input
                            name="status" type="radio" value="0">否</cite></li>
            <li><label>&nbsp;</label><input name="dosubmit" onclick="input_ok(document.myform)" type="button"
                                            class="btn" value="确认保存">&nbsp;&nbsp;&nbsp;&nbsp;<input name="back"
                                                                                                    onclick="javascript:history.back(-1)"
                                                                                                    type="button"
                                                                                                    class="btn"
                                                                                                    value="取消"></li>
        </ul>
    </form>

</div>


<div id="edui_fixedlayer" class="edui-default" style="position: fixed; left: 0px; top: 0px; width: 0px; height: 0px;">
    <div id="edui229" class="edui-dialog edui-for-snapscreen edui-default" style="display: none;">
        <div class="edui-dialog edui-for-snapscreen edui-default">
            <div id="edui229_body" class="edui-dialog-body edui-default">
                <div class="edui-dialog-shadow edui-default"></div>
                <div id="edui229_titlebar" class="edui-dialog-titlebar edui-default">
                    <div class="edui-dialog-draghandle edui-default"
                         onmousedown="$EDITORUI[&quot;edui229&quot;]._onTitlebarMouseDown(event, this);"><span
                                class="edui-dialog-caption edui-default">截图</span></div>
                    <div id="edui230" class="edui-box edui-button edui-dialog-closebutton edui-default">
                        <div id="edui230_state"
                             onmousedown="$EDITORUI[&quot;edui230&quot;].Stateful_onMouseDown(event, this);"
                             onmouseup="$EDITORUI[&quot;edui230&quot;].Stateful_onMouseUp(event, this);"
                             onmouseover="$EDITORUI[&quot;edui230&quot;].Stateful_onMouseOver(event, this);"
                             onmouseout="$EDITORUI[&quot;edui230&quot;].Stateful_onMouseOut(event, this);"
                             class="edui-default">
                            <div class="edui-button-wrap edui-default">
                                <div id="edui230_body" unselectable="on" class="edui-button-body edui-default"
                                     onmousedown="return $EDITORUI[&quot;edui230&quot;]._onMouseDown(event, this);"
                                     onclick="return $EDITORUI[&quot;edui230&quot;]._onClick(event, this);">
                                    <div class="edui-box edui-icon edui-default"></div>
                                    <div class="edui-box edui-label edui-default"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="edui229_content" class="edui-dialog-content edui-default"></div>
                <div class="edui-dialog-foot edui-default">
                    <div id="edui229_buttons" class="edui-dialog-buttons edui-default">
                        <div id="edui231" class="edui-box edui-button edui-okbutton edui-default">
                            <div id="edui231_state"
                                 onmousedown="$EDITORUI[&quot;edui231&quot;].Stateful_onMouseDown(event, this);"
                                 onmouseup="$EDITORUI[&quot;edui231&quot;].Stateful_onMouseUp(event, this);"
                                 onmouseover="$EDITORUI[&quot;edui231&quot;].Stateful_onMouseOver(event, this);"
                                 onmouseout="$EDITORUI[&quot;edui231&quot;].Stateful_onMouseOut(event, this);"
                                 class="edui-default">
                                <div class="edui-button-wrap edui-default">
                                    <div id="edui231_body" unselectable="on" class="edui-button-body edui-default"
                                         onmousedown="return $EDITORUI[&quot;edui231&quot;]._onMouseDown(event, this);"
                                         onclick="return $EDITORUI[&quot;edui231&quot;]._onClick(event, this);">
                                        <div class="edui-box edui-icon edui-default"></div>
                                        <div class="edui-box edui-label edui-default">确认</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="edui232" class="edui-box edui-button edui-cancelbutton edui-default">
                            <div id="edui232_state"
                                 onmousedown="$EDITORUI[&quot;edui232&quot;].Stateful_onMouseDown(event, this);"
                                 onmouseup="$EDITORUI[&quot;edui232&quot;].Stateful_onMouseUp(event, this);"
                                 onmouseover="$EDITORUI[&quot;edui232&quot;].Stateful_onMouseOver(event, this);"
                                 onmouseout="$EDITORUI[&quot;edui232&quot;].Stateful_onMouseOut(event, this);"
                                 class="edui-default">
                                <div class="edui-button-wrap edui-default">
                                    <div id="edui232_body" unselectable="on" class="edui-button-body edui-default"
                                         onmousedown="return $EDITORUI[&quot;edui232&quot;]._onMouseDown(event, this);"
                                         onclick="return $EDITORUI[&quot;edui232&quot;]._onClick(event, this);">
                                        <div class="edui-box edui-icon edui-default"></div>
                                        <div class="edui-box edui-label edui-default">取消</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="edui127" class="edui-mask  edui-dialog-modalmask edui-default"
         onclick="return $EDITORUI[&quot;edui127&quot;]._onClick(event, this);"
         onmousedown="return $EDITORUI[&quot;edui127&quot;]._onMouseDown(event, this);" style="display: none;"></div>
    <div id="edui128" class="edui-mask  edui-dialog-dragmask edui-default"
         onclick="return $EDITORUI[&quot;edui128&quot;]._onClick(event, this);"
         onmousedown="return $EDITORUI[&quot;edui128&quot;]._onMouseDown(event, this);" style="display: none;"></div>
    <div id="edui268" class="edui-popup  edui-bubble edui-default" onmousedown="return false;" style="display: none;">
        <div id="edui268_body" class="edui-popup-body edui-default">
            <iframe style="position:absolute;z-index:-1;left:0;top:0;background-color: transparent;" frameborder="0"
                    width="100%" height="100%" src="about:blank" class="edui-default"></iframe>
            <div class="edui-shadow edui-default"></div>
            <div id="edui268_content" class="edui-popup-content edui-default"></div>
        </div>
    </div>
</div>
<div id="global-zeroclipboard-html-bridge" class="global-zeroclipboard-container"
     style="position: absolute; left: 0px; top: -9999px; width: 1px; height: 1px; z-index: 999999999;">
    <object id="global-zeroclipboard-flash-bridge" name="global-zeroclipboard-flash-bridge" width="100%" height="100%"
            type="application/x-shockwave-flash"
            data="/other/ueditor/third-party/zeroclipboard/ZeroClipboard.swf?noCache=1478067688041">
        <param name="allowScriptAccess" value="sameDomain">
        <param name="allowNetworking" value="all">
        <param name="menu" value="false">
        <param name="wmode" value="transparent">
        <param name="flashvars"
               value="trustedOrigins=qjwm.dianfengcms.com%2C%2F%2Fqjwm.dianfengcms.com%2Chttp%3A%2F%2Fqjwm.dianfengcms.com">
    </object>
</div>
</body>
</html>