/**
 * Created by Daylemon on 2016/9/26.
 */

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
        success : function (result){
            // $(document.createElement('button')).text(result).appendTo($('body'));
            if(result != '') {
            // if(false) {
                var jsonObj = JSON.parse(result);
                var a = jsonObj[0];
                var b = jsonObj[0].title;
                for (var i = 0; i < jsonObj.length; i ++){
                    // $(document.createElement('button')).text("title:" + jsonObj[i].title).appendTo($('body'));
                    $(document.createElement('button')).text("content:" + jsonObj[i].content).prependTo($('body'));
                }

                // $(document.createElement('button')).text(JSON.stringify(result)).appendTo($('body'));
            }
            // $(document.createElement('button')).text(result).appendTo($('body'));
            // $(document.createElement('img')).text(result).append($('.body'));
        },
    });
}


// 5s
var timer = window.setInterval(loadContent, 5000);

// clearInterval(timer);


