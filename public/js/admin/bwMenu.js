
(function($){
    $.fn.bwMenu = function(options){
        var defaults = {
			
        };
        var options = $.extend(defaults, options);
			
        var $obj = $(this);
        $obj.find("dt").first().children("a").addClass("hover");
        $obj.find("dd").first().show();
        $obj.find("dd a").click(function(){
                $obj.find("dd a").removeClass("hover");            
                $(this).addClass("hover");
        });
        $obj.find("dt").live("click", function(){  
            $(this).siblings("dt").find("a").removeClass("hover");
            $obj.find("dd a").removeClass("hover");      
            $(this).parent().find("dd").slideUp();
            $(this).find("a").addClass("hover").end().next("dd").toggle();
            //					.siblings("dd").hide();
            if($(this).next('dd').css('display') == 'block'){
                $(this).next('dd').find('a').each(function(){
                    if($(this).attr('data_open') == 1){
                        $('#mainFrame').attr('src', $(this).attr('href'));     
                        $(this).addClass("hover")
                    }
                });
            }
        });
	
        //初始化obj
        return this;
    };
})(jQuery);