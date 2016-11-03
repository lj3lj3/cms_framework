<html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>DFCMS-网站管理系统</title>
    <link href="/css/admin/style.css" rel="stylesheet" type="text/css">
    <link href="/css/admin/select.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/js/jquery.js"></script>
    <script type="text/javascript" src="/js/admin/select-ui.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".add").click(function(){
                location.href="create";
            });
            $(".shift").click(function(){
                var j=0;
                var m=0;
                var oCB = document.getElementsByName('checkbox[]');
                var nCheck = 0;
                var nDisabled = 0;
                for(var i=0;i<oCB.length;i++)
                {
                    if(oCB[i].checked==true)
                    {
                        j++;
                        m=oCB[i].value;
                    }
                }

                if (j < 1)
                {
                    $("#error").fadeIn(200);
                    return false;
                }else{
                    document.form1.action="shift.php";
                    document.form1.submit();
                }
            });

            $(".audit").click(function(){
                var j=0;
                var m=0;
                var oCB = document.getElementsByName('checkbox[]');
                var nCheck = 0;
                var nDisabled = 0;
                for(var i=0;i<oCB.length;i++)
                {
                    if(oCB[i].checked==true)
                    {
                        j++;
                        m=oCB[i].value;
                    }
                }

                if (j < 1)
                {
                    $("#error").fadeIn(200);
                    return false;
                }else{
                    document.form1.action="audit.php";
                    document.form1.submit();
                }
            });
            $(".del").click(function(){
                var j=0;
                var m=0;
                var oCB = document.getElementsByName('checkbox[]');
                var nCheck = 0;
                var nDisabled = 0;
                for(var i=0;i<oCB.length;i++)
                {
                    if(oCB[i].checked==true)
                    {
                        j++;
                        m=oCB[i].value;
                    }
                }

                if (j < 1)
                {
                    $("#error").fadeIn(200);
                    return false;
                }else{
                    $("#del").fadeIn(200);
                }
            });
            $(".back").click(function(){
                var j=0;
                var m=0;
                var oCB = document.getElementsByName('checkbox[]');
                var nCheck = 0;
                var nDisabled = 0;
                for(var i=0;i<oCB.length;i++)
                {
                    if(oCB[i].checked==true)
                    {
                        j++;
                        m=oCB[i].value;
                    }
                }

                if (j < 1)
                {
                    $("#error").fadeIn(200);
                    return false;
                }else{
                    document.form1.action="back.php";
                    document.form1.submit();
                }
            });
            $(".setup").click(function(){
                $("#setup").fadeIn(200);
            });


            $(".reload").click(function(){
                location.reload();
            });

            $(".tiptop a").click(function(){
                $(".tip").fadeOut(200);
            });

            $(".sure").click(function(){
                $(".tip").fadeOut(100);
            });

            $("#delok").click(function(){
                document.form1.action="Del.php";
                document.form1.submit();
            });

            $(".cancel").click(function(){
                $(".tip").fadeOut(100);
            });

            $(".select3").uedSelect({
                width : 100
            });
        });



        var oEle = document.getElementsByName("checkbox")
        function chooseall(v,obj)
        {
            if(v==undefined){
                $("#error").fadeIn(200);
                return false;
            }
            else
            {
                if(v.length==undefined)
                {
                    v.checked=obj.checked;
                }
                else
                {
                    for(var i=0;i<v.length;i++)
                    {
                        var e=v[i];
                        e.checked=obj.checked;
                    }
                }
            }
            chkclick();
        }

        function choosefalse(v,obj)
        {
            if(v==undefined){
                $("#error").fadeIn(200);
                return false;
            }
            else
            {
                if(v.length==undefined)
                {
                    if(v.checked==true)
                        v.checked=false;
                    else
                        v.checked=true;
                }
                else
                {
                    for(var i=0;i<v.length;i++)
                    {
                        var e=v[i];
                        if(e.checked)
                            e.checked=false;
                        else
                            e.checked=true;
                    }
                }
            }
            chkclick();

        }

        function chkclick()
        {
            var oCB = document.getElementsByName('checkbox[]');
            var nCheck = 0;
            var nDisabled = 0;
            for (var i=0;i<oCB.length;i++)
            {
                if(oCB[i].checked)
                {
                    return;
                }
            }
        }
    </script>


</head>


<body>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li>首页</li>
        <li>内容管理</li>
        <li>普通文章</li>
    </ul>
</div>
<div class="formbody">


    <div id="usual1" class="usual">
        <div class="tools">

            <ul class="toolbar">
                <li class="add"><span><img src="/images/admin/ic_add.png"/></span>添加</li>
                <li class="audit"><span><img src="/images/admin/ic_hegao.png"></span>审核</li>
                <li class="back"><span><img src="/images/admin/ic_tuigao.png"></span>退稿</li>
                <li class="shift"><span><img src="/images/admin/ic_move.png"></span>移动</li>
                <li class="del"><span><img src="/images/admin/ic_delete.png"></span>删除</li>
                <li class="reload"><span><img src="/images/admin/ic_reload.png"></span>刷新</li>
            </ul>
            <ul class="toolbar1">
                <li class="setup"><span><img src="/images/admin/ic_settings.png"></span>设置</li>
            </ul>
        </div>
        <div class="tabson">
            <form name="search" method="get" action="">
                <ul class="seachform">
                    <li><label>综合查询</label><input name="key" type="text" class="scinput" id="key" value="">
                    </li>
                    <li><label>状态</label>
                        <div class="vocation">
                            <div class="uew-select"><div class="uew-select-value ue-state-default" style="width: 73px;"><em class="uew-select-text">全部</em><em class="uew-icon uew-icon-triangle-1-s"></em></div><select name="status" class="select3" id="status" style="width: 100px;">
                                    <option value="">全部</option>
                                    <option value="1">启用</option>
                                    <option value="0">不启用</option>
                                </select></div>
                        </div>
                    </li>

                    <li><label>&nbsp;</label><input type="submit" class="scbtn" value="查询"></li>

                </ul>
            </form>
            <form name="form1" method="post">
                <table class="tablelist">
                    <thead>
                    <tr>
                        <th width="5%"><input type="checkbox" name="chkall" onclick="chooseall(document.form1.checkbox,this);"></th>
                        <th width="5%">编号<i class="sort"><img src="/images/admin/px.gif"></i></th>
                        <th>标题</th>
                        <th width="15%">发布时间</th>
                        <th width="10%">发布人</th>
                        <th width="10%">所属分类</th>
                        <th width="5%">状态</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    {assign var="index" value=0}
                    {foreach $articles as $article}
                        {$index = $index + 1}
                        <tr>
                            <td><input type="checkbox" id="checkbox" value="{$article.id}" name="checkbox[]"
                                       onclick="chkclick
                            ();"></td>
                            <td>{$index}</td>
                            <td><a href="/article/show?id={$article.id}" target="_blank"><span style="">{$article.title}</span></a></td>
                            <td>{$article.updatetime}</td>
                            <td>{$article.username}</td>
                            <td>{$article.catid}</td>
                            <td>{if $article.status == 99}
                                    已发布
                                {else}
                                    未发布
                                {/if}
                            </td>
                            <td><a href="/admin/adminArticle/edit?id={$article.id}" class="tablelink">修改</a>     <a
                                        href="/admin/adminArticle/delete?id={$article.id}" onclick="return confirm
                                        ('确认要删除{$article.title}吗？');"
                                        class="tablelink"> 删除</a></td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </form>


            <div class="pagin">
                {$pageHtml}
            </div>


            <div class="tip" id="del">
                <div class="tiptop"><span>提示信息</span><a></a></div>

                <div class="tipinfo">
                    <span><img src="../images/del.png"></span>
                    <div class="tipright">
                        <p>是否确认删除选择的记录 ？</p>
                        <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
                    </div>
                </div>

                <div class="tipbtn">
                    <input name="" type="button" id="delok" class="sure" value="确定">&nbsp;
                    <input name="" type="button" class="cancel" value="取消">
                </div>

            </div>
            <div class="tip" id="error">
                <div class="tiptop"><span>提示信息</span><a></a></div>

                <div class="tipinfo">
                    <span><img src="../images/error.png"></span>
                    <div class="tipright">
                        <p>请选择要进行操作的记录!</p>
                        <cite>点击确定返回进行选择。</cite>
                    </div>
                </div>

                <div class="tipbtn">
                    <input name="" type="button" class="sure" value="确定">
                </div>

            </div>

            <div class="tip" id="errora">
                <div class="tiptop"><span>提示信息</span><a></a></div>

                <div class="tipinfo">
                    <span><img src="../images/error.png"></span>
                    <div class="tipright">
                        <p>只能选择一条记录进行修改!</p>
                        <cite>点击确定返回重新选择。</cite>
                    </div>
                </div>

                <div class="tipbtn">
                    <input name="" type="button" class="sure" value="确定">
                </div>

            </div>
            <div class="tip" id="del">
                <div class="tiptop"><span>提示信息</span><a></a></div>

                <div class="tipinfo">
                    <span><img src="../images/del.png"></span>
                    <div class="tipright">
                        <p>是否确认删除选择的记录 ？</p>
                        <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
                    </div>
                </div>

                <div class="tipbtn">
                    <input name="" type="button" id="delok" class="sure" value="确定">&nbsp;
                    <input name="" type="button" class="cancel" value="取消">
                </div>

            </div>
            <div class="tip" id="error">
                <div class="tiptop"><span>提示信息</span><a></a></div>

                <div class="tipinfo">
                    <span><img src="../images/error.png"></span>
                    <div class="tipright">
                        <p>请选择要进行操作的记录!</p>
                        <cite>点击确定返回进行选择。</cite>
                    </div>
                </div>

                <div class="tipbtn">
                    <input name="" type="button" class="sure" value="确定">
                </div>

            </div>
            <div class="tip" id="setup">
                <div class="tiptop"><span>提示信息</span><a></a></div>
                <form name="setup" method="get" action="">
                    <input name="catid" type="hidden" value="4">
                    <input name="ses" type="hidden" value="1">
                    <div class="tipinfo">
                        <span><img src="../images/setup.png"></span>
                        <div class="tipright">
                            <p>设置每页显示数量!</p>
                            <div class="uew-select"><div class="uew-select-value ue-state-default" style="width: 73px;"><em class="uew-select-text">默认</em><em class="uew-icon uew-icon-triangle-1-s"></em></div><select name="setup" class="select3" id="status" style="width: 100px;">
                                    <option value="20">默认</option>
                                    <option value="30">30条</option>
                                    <option value="50">50条</option>
                                    <option value="100">100条</option>
                                    <option value="200">200条</option>
                                </select></div>
                        </div>
                    </div>

                    <div class="tipbtn">
                        <input name="" type="submit" class="sure" value="确定">&nbsp;
                        <input name="" type="button" class="cancel" value="取消">
                    </div>
                </form>

            </div>

        </div>

    </div>
    <script type="text/javascript">
        $('.tablelist tbody tr:odd').addClass('odd');
    </script>
</div>



</body></html>