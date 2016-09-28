(function($){
	$.fn.bwLayout = function(options){
		var defaults = {
			bwHeader : "header",
			bwMain : "main",
			bwLeft : "left",
			bwMenu : "menu",
			bwMainFrame : "mainFrame",
			bwContent: "content",
			bwCloseMenu: "close_menu",
			bwMenuUpDown: ".main_menu_bar"
		};
		var options = $.extend(defaults, options);
		
		/**
		* 初始化obj
		*/
		var $obj = $(this);
		var $bwHeader = $("#"+options.bwHeader);
		var $bwMain = $("#"+options.bwMain);
		var $bwLeft = $("#"+options.bwLeft);
		var $bwMenu = $("#"+options.bwMenu);
		var $bwMainFrame = $("#"+options.bwMainFrame);
		var $bwContent = $("#"+options.bwContent);
		var $bwCloseMenu = $("#"+options.bwCloseMenu);
		var $bwMenuUpDown = $(options.bwMenuUpDown);
		
                
                 $("#left ul li").eq(0).addClass("curr").find("a").addClass("hover");
                /**
                 *左侧菜单上下按钮点击
                 */
                var menuuptime;
                var menudowntime;
                $bwMenuUpDown.find(".menu_up").mousedown(function(){
                    menuuptime=setInterval(
                        function (){
                                $ulmargintop=parseInt($bwLeft.find("ul").css("margin-top"));
                                if($ulmargintop<0)
                                $bwLeft.find("ul").css("margin-top",($ulmargintop+5)+"px");                 
                        }
                        ,10);
                }).mouseup(function(){
                    clearTimeout(menuuptime);
                });
                $bwMenuUpDown.find(".menu_down").mousedown(function(){
                    menudowntime=setInterval(
                        function (){
                                $ulmargintop=parseInt($bwLeft.find("ul").css("margin-top"));
                                if(($ulmargintop+$bwLeft.find("ul").height()+5)>$bwLeft.height()){
                                     $bwLeft.find("ul").css("margin-top",($ulmargintop-5)+"px");
                                }                 
                        }
                        ,10);
                }).mouseup(function(){
                    clearTimeout(menudowntime);
                });
                
		/**
		* 框架整体宽高设定
		*/
		resizeObjs = function(){
			var layoutHeight = $obj.height() - $bwHeader.height();
			var $objWidth = $obj.width();
			var contentWidth = $objWidth - $bwLeft.width() - $bwMenu.width();
			if($objWidth < 980){
				$bwHeader.width(980);
				$bwMain.width(980);
			}else{
				$bwHeader.css("width","auto");
				$bwMain.css("width","auto");
			}
			$bwMain.height(layoutHeight);
			$bwLeft.height(layoutHeight);
			$bwMenu.height(layoutHeight);
			$bwContent.height(layoutHeight);
			$bwMainFrame.height(layoutHeight);
                        //显示左侧菜单上下按钮
                        if($bwLeft.height()<600)
                        {
                            $bwMenuUpDown.show();
                        }
                        else
                        {
                            $bwMenuUpDown.hide();
                            $bwLeft.find("ul").css("margin-top","0px");
                        }
		};
		
		resizeObjs();
		
		$obj.resize(function(){
			resizeObjs();
		});
		
		/**
		* 主菜单选中样式
		*/
		$bwLeft.find("a").click(function(){
                        var _this     = $(this);
			var thisClass = _this.attr("class");
			var hasClass  = _this.hasClass("hover");
                        var cpant     = _this.text();
                        _this.parent("li").addClass("curr").siblings("li").removeClass("curr");
                        if(hasClass){return false;}
                        $('#menu_title').text(cpant);
                        $bwMain.find("dd a").removeClass("hover");   
                        var $bwMenu2 = $bwMenu.find("dl").hide().end().find("dl[rel="+thisClass+"]");
                        $bwMenu2.show();
                        var flag = true;
                        $bwMenu2.find('dt').each(function(){
                            var _a = $(this).find("a");
                            if(_a.attr('data_open') == 1){
                                if(_a.hasClass('hover')){
                                    
                                }else{
                                     _a.addClass("hover").end().next("dd").toggle();
                                }
                                if(flag){
                                    $(this).next('dd').find('a').each(function(){
                                        if($(this).attr('data_open') == 1){
                                            $('#mainFrame').attr('src', $(this).attr('href'));                                            
                                            $(this).addClass("hover")
                                            flag = false;
                                        }
                                    });
                                }
                            }  
                        });			
			//ie,看下要不要做兼容,不做的话现在也没什么影响; 如果要做兼容: 直接改backgroundImage
			if($.browser.msie && $.browser.version == "6.0"){return false;}
			$bwLeft.find("a").removeClass("hover");
			_this.addClass("hover");
		});
		
		/**
		* 隐藏菜单域
		*/
		var menuWidth = $bwMenu.width();
		$bwCloseMenu.click(function(){
			if($bwMenu.width() > 1){
				$bwMenu.css("textIndent","-999999px").width(0);
				$bwCloseMenu.addClass("close_menu_cur");
			}else{
				$bwMenu.css("textIndent","0px").width(menuWidth);		
				$bwCloseMenu.removeClass("close_menu_cur");
			}
		});
	};
})(jQuery);