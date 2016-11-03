/**
 * Created by Daylemon on 2016/9/26.
 */



$(".change-line").click(function(){
//            $("#change-line-modal").modal('show');
//            $("#change-line-modal-new").modal('show');

//            $("#change-line-modal").show();
//     $("#chang-line-select").show();
    alert('err');
});
/**
 *
 */
$('#chang-line-select').on('click', 'li', function(e) {
    e.stopPropagation();
    $(this).siblings().removeClass('active');
    $(this).addClass('active');
//            var definitions_active = $('#change-definitions-modal li.active');
//            var definitions_value = definitions_active.attr('value');
    //
//            if(definitions_active.hasClass('change-to-auido') || $("video").length <= 0) {
//                $("audio")[0].src = url;
//                $("audio")[0].play();
//            } else {
    $("video")[0].src = url;
    $("video")[0].play();
//            }
    $('#chang-line-select').hide();
});
/*$('#change-definitions-modal').on('click', 'li', function(e) {
 e.stopPropagation();
 var self = $(this);
 self.siblings().removeClass('active');
 self.addClass('active');
 if ($('video').length > 0) { //当前是视频直播页
 if (self.hasClass('change-to-auido')) { //当前清晰度选择为音频
 if ($('.video-js-box').hasClass('isShow')) { //当前播放的是视频,将切换至音频
 $('.video-js-box').hide().removeClass('isShow');
 $('video')[0].pause();
 $('video')[0].src = '';
 }
 $('.audio-js-box').show();
 //如当前播放的是音频则只更改地址
 $('audio')[0].src = url;
 $('audio')[0].load();
 $('audio')[0].play();
 } else {
 if (!$('.video-js-box').hasClass('isShow')) {
 $('.video-js-box').show().addClass('isShow');
 $('.audio-js-box').hide();
 }
 $('audio')[0].pause();
 $('audio')[0].src = '';
 $('video')[0].src = url;
 $('video')[0].load();
 $('video')[0].play();
 }
 } else { //当前是音频直播页
 if (self.hasClass('change-to-auido')) {  //当前清晰度选择为音频
 $('audio')[0].src = url;
 $('audio')[0].play();
 }
 }*/
/*$("#change-definitions").text($(this).text());
 $('#change-definitions-modal').hide();
 });*/





function loadContent() {
    // var time = new Date();
    // var offset = new Date().getTimezoneOffset();

    // var timeStr = date.toLocaleString();

    // var time = Date.now();
    // Date.

    $.ajax({
        //url: "http://192.168.1.17:8888/temp/temp/refresh",
        url: "http://192.168.1.17:8888/temp/temp/refresh?t=" + Date.now(),
        //1474889875751000
        //1474864260
        // url: "http://localhost:8888/temp/temp/refresh?t=" + 13,
        // crossDomain: true,
        success: function (result) {
            // $(document.createElement('button')).text(result).appendTo($('body'));
            if (result != '') {
                // if(false) {
                var jsonObj = JSON.parse(result);
                var a = jsonObj[0];
                var b = jsonObj[0].title;
                for (var i = 0; i < jsonObj.length; i++) {
                    // $(document.createElement('button')).text("title:" + jsonObj[i].title).appendTo($('body'));
                    $(document.createElement('button')).text("content:" + jsonObj[i].content).hide().prependTo($('body')).slideDown();
                }

                // $(document.createElement('button')).text(JSON.stringify(result)).appendTo($('body'));
            }
            // $(document.createElement('button')).text(result).appendTo($('body'));
            // $(document.createElement('img')).text(result).append($('.body'));
        },
    });
}


function addContent() {

    $(document.createElement('button')).hide().text("new button").prependTo($('body')).slideDown();
    $(document.createElement('button')).hide().text("new button").prependTo($('body')).fadeIn().slideDown(800);
    // $(document.createElement('button')).hide().text("new button").prependTo($('body')).fadeIn().slideDown(800);
    // $(document.createElement('button')).hide().text("new button").prependTo($('body')).fadeIn().slideDown(800);
}


// 5s
// var timer = window.setInterval(addContent, 1000);

// clearInterval(timer);

$(window).scroll(function () {
    var scrollTop = $(this).scrollTop(), docHeight = $(document).height(), windowHeight = $(this).height();
    var positionValue = docHeight - (scrollTop + windowHeight);
    // 自动加载
    if (positionValue <= 5) {
        // 显示加载中
        $("#load").html("loading");
        // 获取lastId
        // html中使用data-lastid属性
        var lastId = $('.comment :last').attr('lastid');

        $.ajax({
            url: "http://192.168.1.17:8888/temp/temp/load?t=" + Date.now(),
            method: "GET",
            data: {
                lastId: lastId
            },
            success: function (data) {
                // load more
                $(createElement('li')).html('')
                $("#ul-load").html(data);
            },
            error: function () {
                // error
                $("#load").html("error");
            }
        });
    }
});
