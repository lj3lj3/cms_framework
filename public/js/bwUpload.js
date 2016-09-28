/*
 * bwUpload! jQuery plugin
 * author: HHH
 * email: 1037956991@qq.com
 * copyright: 厦门中恒天下科技有限公司
 */
/*
封装成函数showUploadDialog了
;(function($){
	$.fn.bwUpload = function(options){
		var defaults = {
			url : "" //要加载的路径
		};
		var options = $.extend(defaults, options);
			
		var $obj = $(this);
		
		$obj.click(function(){
			$(".uploadDialog").remove();
			$.get(options.url, function(data){
				$(document.body).prepend(data);							  
			}); //做个ajax调用. 然后返回最终的html加载到当前页面
			
		});	
		
		
		//初始化obj
		return this;
	};
})(jQuery);
*/
(function($){
	$.fn.bwUploadReturnDialog = function(options){
		var defaults = {
			msg : ""
		};
		var options = $.extend(defaults, options);
			
		var $obj = $(this);
		$(".bwUploadReturnDialog").remove();
		var $html = '<table cellpadding="0" cellspacing="0" width="" class="bwUploadReturnDialog">'+
					'<tr><td class="i_l_t">&nbsp;</td><td class="i_t">&nbsp;</td><td class="i_r_t">&nbsp;</td></tr>'+
					'<tr><td>&nbsp;</td><td class="i_title"><a href="###" class="burd_close"></a>上传结果</td><td>&nbsp;</td></tr>'+
					'<tr><td class="i_l">&nbsp;</td><td class="i_c">'+
						'<table cellpadding="0" cellspacing="0" width="100%">'+
							'<tr>'+
								'<td align="center" valign="middle" width="135"><img src="images/tip_success.jpg" /></td>'+
								'<td>'+options.msg+'</td>'+
							'</tr>'+
					   '</table>'+
					'</td><td class="i_r">&nbsp;</td></tr>'+
					'<tr><td class="i_l_b">&nbsp;</td><td class="i_b">&nbsp;</td><td class="i_r_b">&nbsp;</td></tr>'+
					'</table>';
		
		$(document.body).append($html);
		
		
		$(".burd_close").live("click", function(){
			$(this).closest(".bwUploadReturnDialog").remove();										
		});
		return this;
	};
})(jQuery);

//上传完后返回的函数
function bwUploadReturnDialog(message){
	$(document.body).bwUploadReturnDialog({msg: message});
}


/*
  js上传打开函数
  参数自己定
  url 任意你程序上的调用url
* folder 默认系统上传目录
* type 默认0 批量上传 1 单张上传
* display_mode 默认0 图片 1列表
* pagesize 默认20
* method_name 函数名称 
* editor_index 多语言编辑器索引
*/
function showUploadDialog(folder, function_name, type, display_mode, pagesize,editor_index,default_file){
//        var param = folder ? folder : 0 + '_' + type ? type : 0 + '_' + function_name ? function_name : 0
//                    +display_mode ? display_mode : 0 + '_' + pagesize ? pagesize : 0;
        if(!default_file || default_file=='undefined')
        {
            default_file='';
        }
	var url = admin_url + "?m=admin&c=upload&a=publicDialog&folder=" + folder + "&type=" + type 
                + "&display_mode=" + display_mode + '&pagesize=' + pagesize + '&method_name=' + function_name + '&editor_index=' + editor_index + '&default_file=' + default_file;
	$(".uploadDialog").remove();
	$.get(url, function(data){
		$(document.body).prepend(data);							  
	});
}

/*
  js上传打开函数
  参数自己定
  url 任意你程序上的调用url
* folder 默认系统上传目录
* type 默认0 批量上传 1 单张上传
* display_mode 默认0 图片 1列表
* pagesize 默认20
* method_name 函数名称 
* targetdir 要打开的子目录
*
*/
function showUploadDialogTarget(folder, function_name,targetdir, type, display_mode, pagesize,editor_index,default_file){

        if(!default_file || default_file=='undefined')
        {
            default_file='';
        }
        var url= admin_url + "?m=admin&c=upload&a=publicOpen&type==" + type  + "&display_mode=" + display_mode
            + "&pagesize=" + pagesize + "&method_name="+ function_name+"&opendir=" + folder + "&targetdir="+targetdir + '&default_file=' + default_file;;
	$(".uploadDialog").remove();
	$.get(url, function(data){
		$(document.body).prepend(data);							  
	});
}

function getImageSize(id)
{
	var screenImage = $("#"+id);
	// Create new offscreen image to test
	var theImage = new Image();
	theImage.src = screenImage.attr("src");
	 
	// Get accurate measurements from that.
	var imageWidth = theImage.width;
	var imageHeight = theImage.height;
	return [imageWidth,imageHeight];
}