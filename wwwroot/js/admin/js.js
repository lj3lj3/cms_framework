//建立xmlhttp实例
function createAjax() {            //该函数将返回XMLHTTP对象实例 
    var _xmlhttp; 
    try {     
        _xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");    //IE的创建方式 
    } 
    catch (e) { 
        try { 
            _xmlhttp=new XMLHttpRequest();    //FF等浏览器的创建方式 
        } 
        catch (e) { 
            _xmlhttp=false;        //如果创建失败，将返回false 
        } 
    } 
    return _xmlhttp;    //返回xmlhttp对象实例
	
} 
//模拟alert
function ShowAlert(title,content)
        {
            var pop=new Popup({ contentType:4,isReloadOnClose:false,width:340,height:80});
            pop.setContent("title",title);
            pop.setContent("alertCon",content);
            pop.build();
            pop.show();
        }
//模拟confirm
 function ShowConfirm(title,content,url)
        {
           var pop=new Popup({ contentType:3,isReloadOnClose:false,width:340,height:80});
           pop.setContent("title",title);
           pop.setContent("confirmCon",content);
           pop.setContent("callBack",ShowCallBack);
           pop.build();
           pop.show();
		   function ShowCallBack()
			{
				window.location=url
			}
        }
		
//模拟Iframe
 function ShowIframe(title,url,w,h)
		{
       var pop=new Popup({ contentType:1,scrollType:'no',isReloadOnClose:false,width:w,height:h});
       pop.setContent("contentUrl",url);
       pop.setContent("title",title);
       pop.build();
       pop.show();
        }
//关闭弹出层



//管理员登陆验证	
function chk_login()
{
	var username = document.getElementById("username").value;
	var password = document.getElementById("password").value;
	var code = document.getElementById("code").value;
	if(username=="")
	{
	ShowAlert("提示信息","请填写用户名!")
	return false;	
	}
	if(password=="")
	{
	ShowAlert("提示信息","请填写密码!")
	return false;	
	}
	if(code=="")
	{
	ShowAlert("提示信息","请填写验证码!")
	return false;	
	}
	var ajax =createAjax();
	ajax.open("GET","chk_login.php?action=code&code="+code,false);
	ajax.send(null);
	var rs=unescape(ajax.responseText)
	if (rs==1)
	{
	ShowAlert("提示信息","验证码错误!")
	LoadVerifyPic();
	return false;	
	}
	var ajax =createAjax();
	ajax.open("GET","chk_login.php?action=chkuser&username="+escape(username)+"&password="+password,false);
	ajax.send(null);
	var rs=unescape(ajax.responseText)
	//alert (rs);
	if (rs==0)
	{
	ShowAlert("提示信息","用户名密码错误!")
	LoadVerifyPic();
	document.getElementById("username").value = "";
	document.getElementById("password").value = "";
	return false;	
	}
	else if (rs==2)
	{
	ShowAlert("提示信息","该用户已被锁定!")
	LoadVerifyPic();
	document.getElementById("username").value = "";
}else if (rs==3){
	ShowAlert("提示信息","验证码错误!")
	LoadVerifyPic();
	return false;	
	}
	else
	{
	window.location='main.php';
	}
}



function Changepass()
{
	var oldpass = document.getElementById("oldpass").value;
	var newpass = document.getElementById("newpass").value;
	var renewpass = document.getElementById("renewpass").value;
	if (oldpass=="")
	{
		ShowAlert("提示信息","请填写旧密码!")
		return false;	
		}

	if (newpass=="")
	{
		ShowAlert("提示信息","请填写新密码!")
		return false;	
		}
		
	if (newpass!=renewpass)
	{
		ShowAlert("提示信息","确认密码错误!")
		return false;	
		}
}
function MyChannel()
{
	var title = document.getElementById("title").value;
	var url = document.getElementById("url").value;
	var lb = document.getElementsByName("lb");
	if (title=="")
	{
		ShowAlert("提示信息","请填写频道名称!")
		return false;	
		}
	var count1=0;       
    for(var i=0;i<lb.length;i++)
	{       
        if(lb[i].checked == true)
		{       
             count1=1; 
             break;       
        }      
    }
    if(count1==0){      
	ShowAlert("提示信息","请选择频道类型");
    return false;      
    }
	if (lb[4].checked ==true)
	{
		if (url=="")
		{
		ShowAlert("提示信息","请填写连接地址");
    	return false; 	
		}
	}
}
function Showurl(str)
{ 
	if (str==4)
	{
	document.getElementById("link_url").style.display = 'block';
	}
	else
	{
	document.getElementById("link_url").style.display = 'none';	
	}
}

function Show_templete(str,str1)
{
	if (str1 == 1)
	{
		var en = "_en";
		}
		else
		{
		var en = "";	
			}
			
	switch (str)
	{
	case 0:
	document.getElementById("t_list").style.display = 'none';
	document.getElementById("t_show").style.display = 'block';
	document.getElementById("temp_show").value = 'single_page'+en+'.html';
	document.getElementById("t_text1").innerHTML = '';
	break;
	case 1:
	document.getElementById("t_list").style.display = 'block';
	document.getElementById("t_show").style.display = 'block';
	document.getElementById("temp_list").value = 'news_list'+en+'.html';
	document.getElementById("temp_show").value = 'news_show'+en+'.html';
	document.getElementById("t_text").innerHTML = '列表页';
	document.getElementById("t_text1").innerHTML = '详细页';
	break;
	case 2:
	document.getElementById("t_list").style.display = 'block';
	document.getElementById("t_show").style.display = 'block';
	document.getElementById("t_text").innerHTML = '列表页';
	document.getElementById("t_text1").innerHTML = '详细页';
	document.getElementById("temp_list").value = 'products_list'+en+'.html';
	document.getElementById("temp_show").value = 'products_show'+en+'.html';
	break;
	case 3:
	document.getElementById("t_list").style.display = 'none';
	document.getElementById("t_show").style.display = 'block';
	document.getElementById("temp_show").value = 'feedback_page'+en+'.html';
	document.getElementById("t_text1").innerHTML = '';
	break;
	default:
	document.getElementById("t_list").style.display = 'none';
	document.getElementById("t_show").style.display = 'none';
	}
	
	}
function Showradio(str)
{ 
	if (str==2 || str==3)
	{
	document.getElementById("link_url").style.display = 'block';
	}
	else
	{
	document.getElementById("link_url").style.display = 'none';	
	}
}




function chk_news()
{
	var title = document.getElementById("title").value;
	if (title=="")
	{
		ShowAlert("提示信息","请填写信息主题!")
		return false;	
		}
	
	
}

function chk_products()
{
	var title = document.getElementById("title").value;
	var small_pic = document.getElementById("small_pic").value;
	var big_pic = document.getElementById("big_pic").value;
	if (title=="")
		{
		ShowAlert("提示信息","请填写信息主题!")
		return false;	
		}
	if (small_pic=="")
		{
		ShowAlert("提示信息","请上传小图片!")
		return false;		
		}
	if (big_pic=="")
		{
		ShowAlert("提示信息","请上传大图片!")
		return false;		
		}
	
}
function Myform()
{
	var title = document.getElementById("title").value;
	var other = document.getElementById("other").value;
	var lb =form1.lb;
	if (title=="")
	{
		ShowAlert("提示信息","请填写表单项!")
		return false;	
		}
	var count1=0;       
    for(var i=0;i<lb.length;i++)
	{       
        if(lb[i].checked == true)
		{       
             count1=1; 
             break;       
        }      
    }
    if(count1==0){      
	ShowAlert("提示信息","请选择类型");
    return false;      
    }
	
	if (lb[2].checked ==true || lb[3].checked ==true)
	{
		if (other=="")
		{
		ShowAlert("提示信息","请填写选项");
    	return false; 	
		}
	}
	
	
	}
	
function check_flash()
{
var title = document.getElementById("title").value;
var url = document.getElementById("url").value;
var pic = document.getElementById("pic").value;
if(title=="")
{
	ShowAlert("提示信息","请填写标题");
	return false;
	}
	
if(url=="")
{
	ShowAlert("提示信息","连接地址不能为空！");
	return false;
	}
if(pic==""){
	ShowAlert("提示信息","请上传图片!");
	return false;
	}
}
function gettemplete(str,str1)
{
window.top.main.document.getElementById(str).value = str1;
window.top.main.document.getElementById('dialogCase').style.display = 'none';	
	}
	
	
function chk_link(){
var title = document.getElementById("title").value;
var url = document.getElementById("url").value;
var small_pic = document.getElementById("small_pic").value;
if(title=="")
{
	ShowAlert("提示信息","请填写网站名称");
	return false;
	}
	
if(url=="")
{
	ShowAlert("提示信息","连接地址不能为空！");
	return false;
	}
if(small_pic==""){
	ShowAlert("提示信息","请上传logo!");
	return false;
	}
}	
	