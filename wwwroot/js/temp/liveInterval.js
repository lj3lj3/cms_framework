/// <reference path="../../../core/imwebsocket.js" />
/// <reference path="wtCommon.js" />
(function ($) {
    $.fn.extend({
        insertAtCaret: function (myValue) {
            var $t = $(this)[0];
            if (document.selection) {
                this.focus();
                sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
            } else
                if ($t.selectionStart || $t.selectionStart == '0') {
                    var startPos = $t.selectionStart;
                    var endPos = $t.selectionEnd;
                    var scrollTop = $t.scrollTop;
                    $t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
                    this.focus();
                    $t.selectionStart = startPos + myValue.length;
                    $t.selectionEnd = startPos + myValue.length;
                    $t.scrollTop = scrollTop;
                } else {
                    this.value += myValue;
                    this.focus();
                }
        }
    })
})(jQuery);
; function moveToEnd(mainBox, isLoad) {
    var windowHeight = mainBox.outerHeight(),
		pageHeight = mainBox.find(".liveBoxContent").outerHeight(),
		isSrollY = mainBox.scrollTop();
    //if (isLoad || (pageHeight - isSrollY - windowHeight) < 300) {
    //mainBox.stop().animate({ scrollTop: pageHeight - windowHeight }, 100);
    //}
    //mainBox.stop().animate({ scrollTop: pageHeight - windowHeight }, 1);
    mainBox.scrollTop(pageHeight - windowHeight);
}
//弹，关
function queueTanmu() {
    if ($(".isdan_btn_a").text() == "关") {
        //var a = "";
        var arr_tan = [];
        var cmt1 = $(".comment_dd").eq(-1);
        arr_tan.push(cmt1);
        for (var i = 0; i < arr_tan.length; i++) {
            var current_node = arr_tan[i];
            if (current_node.length > 0 && $(".danmulist dd[attr-id='" + current_node.attr("attr-id") + "']").length <= 0) {
                var tempstr = $('<dd style="display:none;" attr-id="' + current_node.attr("attr-id") + '"><p>' + current_node.find(".content").html() + '</p><i><img src="' + current_node.find(".avatar img").attr("src") + '"></i></dd>');
                if ($(".danmulist dd").length >= 3) {
                    $(".danmulist dd:first").remove();
                    $(".danmulist").append(tempstr);
                    tempstr.show();
                }
                else {
                    $(".danmulist").append(tempstr);
                    tempstr.show();
                }

            }
        }
    }
}
var isTalking = true;
//当前输入模式 默认为直播,点击评论为comment
var inputMode = "live";
//相册实例
var photoswipe;
function bindPhotoSwipe() {
    if (isWX()||$("body").hasClass("ps-active")) {
        return;
    }
    var _options = {
        enableMouseWheel: true,
        enableKeyboard: true,
        loop: false,
        captionAndToolbarShowEmptyCaptions: false
    }
    
    //if ($("img[fullsrc]").length > 0) {
    //    //防止重复绑定
    //    if (photoswipe) {
    //        window.Code.PhotoSwipe.detatch(photoswipe);
    //        window.Code.PhotoSwipe.activeInstances = [];
    //    }

    //    photoswipe = $("img[fullsrc]").photoSwipe(_options);
    //}

}

$(function () {
    /*var isiOSBoolean = isiOS();
    var noContentHtml = '<div class="box_nothing" style="display:block;"><span class="tips_1">没有更多</span></div>';

    function resetLoadingBox() {
        $(".loadingStop").stop().animate({ marginBottom: "-50px" }, 500);
    }
    //直播栏目tab
    $(".header_tab a").click(function () {
        var btnName = $(this).attr("name");

        $(this).addClass("on").siblings().removeClass("on");
        $(".liveTabBox[name=" + btnName + "]").addClass("imScroll").siblings().removeClass("imScroll");
        if (isiOSBoolean) {
            $(".liveTabBox[name=" + btnName + "]").show().siblings().hide();
        }
        //点关于的时候隐藏登陆按钮
        if (btnName == 'about') {
            $(".login_box").hide();
        }
        else {
            //只有未登陆的时候才显示
            if (IsNullOrEmpty(zbvd.userid) || zbvd.userid == 0 || zbvd.userid == "0") {
                $(".login_box").show();
            }
        }
        hideBottom();
    });

    hideBottom();

    function hideBottom() {
        $("body").addClass("nobottom");
        //首先要登陆
        if (IsNullOrEmpty(zbvd.userid) || zbvd.userid == 0) {
            $("body").removeClass("hasTabBottom").removeClass("textBottom");
            return;
        }
        switch (inputMode) {
            case "live":
                /!*直播区只允许管理员在直播开始时候输入
                只有状态是beginning
                图文，视频，角色用户可以发
                群聊任何人都可以发
                *!/
                if (liveStatus == "beginning" || liveStatus == "plan") {
                    // 主题模式 0==讲座模式  1==群聊模式  2==视频直播 3==视频录制 
                    if ("1,2,3,4".indexOf(zbvd.modeltype) > -1 || powerEntity.allowSpeak) {
                        $("body").addClass("hasTabBottom");
                    }
                    else {
                        $("body").removeClass("hasTabBottom").removeClass("textBottom");
                    }
                }
                else {
                    $("body").removeClass("hasTabBottom").removeClass("textBottom");

                    //视频结束后评论判断
                    if (zbvd.iscomment) {
                        $("body").attr("class", "hasTabBottom");
                    }
                }
                break;
            case "comment":
                if (liveStatus != "ended" || zbvd.iscomment) {
                    $("body").addClass("hasTabBottom");
                }
                break;
            default:
                //$(".live_ask").hide();
                $("body").removeClass("hasTabBottom").removeClass("textBottom");
                break;

        }
    }

    //直播发言提交
    function liveTalk(type, content, commentId, tuserid, second, msgtypes) {
        if (isTalking) {
            isTalking = false;
            var isReplay = "N";

            if (commentId != "") {
                isReplay = "Y";
            }
            content = content.toString();
            if (content.trim() == "") {
                $(document).minTipsBox({
                    tipsContent: "内容不能为空",
                    tipsTime: 1
                });
                isTalking = true;
                return false;
            } else if (content.trim().length > 2000) {
                $(document).minTipsBox({
                    tipsContent: "内容字数不能超过2000字",
                    tipsTime: 1
                });
                isTalking = true;
                return false;
            }
            var isGo = true;
            if (wss == null || wss.readyState == 3) {
                $.when($.get("/live/reconn")).done(function () {
                    imwebsocket.ConnectServer();
                    isGo = false;
                });
            };
            var datats = 200;
            if (!isGo) { datats = 1500, isGo = true };
            setTimeout(function () {
                if (wss) {
                    imwebsocket.SendMessage(type, content, commentId, tuserid, second, msgtypes);
                    if (type == "text") {
                        $(".commentInput").val("");
                    }
                    if (msgtypes == 1) {
                        $(".speakInput").val("");
                    }
                    isTalking = true;

                    if (isReplay == "Y") {
                        var btnHtml = '<i class="btn_iswalled">已上墙</i>'
                        $("#commentDl [attr-id=" + commentId + "] .right_info").prepend(btnHtml);
                        $("#commentDl [attr-id=" + commentId + "] .btn_wall").remove();
                        $(".commentReplyBox").hide();
                    }
                }
                $(".btnLiveTalk").hide();
                $(".btnInputMore").show();
            }, datats);
        };
    };

    //直播历史发言
    var isLoading = true;
    var hasTalkHistory = true;
    function talkHistory() {
        if (isLoading && hasTalkHistory) {
            isLoading = false;
            $(".btnLoadSpeak").addClass("on");
            var loadTime = $("#speakBubbles dd:first").eq(0).attr("attrtime");
            //如果话题已结束 倒序查询
            var selMode = 'desc';
            if (((liveStatus == "ended" || liveStatus == "plan") && zbvd.watchmode == "") || zbvd.watchmode == "asc") {
                $(".btnLoadSpeak").addClass("asc");
                selMode = "asc";
                loadTime = $("#speakBubbles dd[attrtime]:last").eq(0).attr("attrtime");
            }

            $.ajax({
                type: "GET",
                url: "/live/getSpeak",
                data: {
                    zbid: (parseInt(zbvd.zbid) || 0),
                    pagesize: '10',
                    time: loadTime,
                    topicid: (parseInt(zbvd.topicid) || 0),
                    skin: "bw",
                    mode: selMode
                },
                success: function (result) {
                    isLoading = true;
                    resetLoadingBox();
                    if (result != '') {
                        var $result = $(result);
                        if (((liveStatus == "ended" || liveStatus == "plan") && zbvd.watchmode == "") || zbvd.watchmode == "asc") {
                            $(result).appendTo($("#speakBubbles"));
                        }
                        else {
                            $(result).prependTo($("#speakBubbles"));
                        }

                        setTimeout(function () {
                            $("#speakBubbles .recordingMsg").each(function () {
                                imReaded($(this).parents("dd").attr("attr-id"));
                            });
                            var lastReadLocation = $("#speakBubbles dd[attrtime='" + loadTime + "']").get(0);
                            if (lastReadLocation) {
                                lastReadLocation.scrollIntoView(false);
                            }
                        }, 1);

                    }
                    else {
                        hasTalkHistory = false;
                    }
                    //加载完数据之后重新绑定
                    //bindPhotoSwipe();
                    $(".btnLoadSpeak").removeClass("on");
                },
                error: function () {
                    isLoading = true;
                    resetLoadingBox();
                }
            });
        }
    };

    //滚动加载帖子
    $("#speakBox").scroll(function () {
        if (((liveStatus == "ended" || liveStatus == "plan") && zbvd.watchmode == '') || (zbvd.watchmode == 'asc')) {
            if (($("#speakBox").scrollTop() + $("#speakBox").height()) >= ($(".liveBoxContent").outerHeight())) {
                talkHistory();
            }
        }
        else {
            if ($("#speakBox").scrollTop() == 0) {
                talkHistory();
            }
        }

    });

    $("#commentBox").scroll(function () {
        if ($("#commentBox").scrollTop() == 0) {
            commentHistory();
        }
        lastCommentScrollPosition = $(this).scrollTop();
        //console.log(lastCommentScrollPosition);
    });


    //评论历史
    var noCommentHistory = false;
    function commentHistory() {
        if (isLoading && !noCommentHistory) {
            isLoading = false;
            $(".btnLoadComment").addClass("on");
            var loadTime = $(".comment_dd").eq(0).attr("attrtime");

            $.ajax({
                type: "GET",
                url: baseURL + "/live/getComments",
                data: { liveId: zbvd.zbid, time: loadTime, pageSize: '10', topicId: zbvd.topicid, skin: "bw" },
                success: function (result) {
                    isLoading = true;
                    $(".btnLoadComment").removeClass("on");
                    if (result != '') {
                        noCommentHistory = false;
                        $("#commentDl").prepend(result);
                    }
                    else {
                        noCommentHistory = true;
                        //有评论的时候再显示 ，没有就不要提示了
                        if ($("#commentDl dd").length > 0) {
                            $("#commentDl .nodata").prependTo("#commentDl").show();
                        }
                        resetLoadingBox();
                    }


                    setTimeout(function () {
                        $("#commentDl .recordingMsg").each(function () {
                            imReaded($(this).parents("dd").attr("attr-id"));
                        });
                        var lastReadLocation = $("#commentDl dd[attrtime='" + loadTime + "']").get(0);
                        if (lastReadLocation) {
                            lastReadLocation.scrollIntoView(false);
                        }
                    }, 500);
                },
                error: function () {
                    isLoading = true;
                    resetLoadingBox();
                }
            });
        }


    };

    //直播点赞处理
    function speakVoteHandle(data) {
        if ($("#speakBubbles [attr-id=" + data.speakId + "]").length > 0) {
            var likeBtn = $("#speakBubbles [attr-id=" + data.speakId + "]").find(".liveflower");
            var likeNum = Number(likeBtn.text());

            if (data.id != userId) {
                likeBtn.text(++likeNum);
            } else {
                if (!likeBtn.hasClass("on")) {
                    likeBtn.addClass("on");
                    likeBtn.text(++likeNum);
                }
            }
        }

    };


    //上墙、点赞
    $(document).on("click", ".btn_wall", function () {
        var replyToName = $(this).parents(".comment_dd").find(".author_name").text();

        $(".commentReplyBox textarea").attr("placeholder", "@" + replyToName);
        $(".commentReplyBox").attr("attrCommentId", $(this).parents(".comment_dd").attr("attr-id"));
        $(".commentReplyBox").attr("tuserid", $(this).parents(".comment_dd").attr("attrcreateby"));
        $(".commentReplyBox textarea").val("");
        $(".commentReplyBox").show();
    }).on("click", ".btn_like,.btn_hate", function () {

        var voteType,
			commentId = $(this).parents(".comment_dd").attr("attr-id"),
			LOrH = "liked",
			removeLOrH = "hated",
			self = $(this);

        if ($(this).hasClass("btn_like")) {
            voteType = "likes";
        } else if ($(this).hasClass("btn_hate")) {
            voteType = "despise";
            LOrH = "hated",
			removeLOrH = "liked";
        }

        if (!$(this).parents(".comment_dd").hasClass(LOrH)) {
            $(this).parents(".comment_dd").addClass(LOrH);

            $.ajax({
                type: "POST",
                url: baseURL + "/liveajax/InsertPraise",
                data: { zbid: zbvd.zbid, tpid: zbvd.topicid, voteType: voteType, id: commentId },
                success: function (result) {
                    var data = result;
                    if (data && data.isok) {
                        self.parents(".comment_dd").removeClass(removeLOrH);
                        var haslikes = "",
							hasdespise = "";

                        var commentDd = $("#commentDl [attr-id=" + commentId + "]");
                        var num = parseInt(commentDd.find(".btn_like").text()) || 0;
                        num += 1;
                        commentDd.find(".btn_like").text(num);
                        commentDd.addClass("liked").removeClass("hated");

                        $(document).minTipsBox({
                            tipsContent: data.Msg,
                            tipsTime: 1
                        });

                    } else {
                        $(document).minTipsBox({
                            tipsContent: data.Msg,
                            tipsTime: 1
                        });
                    }

                },
                error: function () {
                    self.parents(".comment_dd").removeClass(LOrH);

                }
            });
        }



    });
    //投票处理
    function voteHandle(data) {
        if ($("#commentDl [attr-id=" + data.commentId + "]").length > 0) {

            //commentDd.find(".btn_hate").text(data.liveCommentPo.despiseNum);

            if (data.id == userId) {
                switch (data.voteType) {
                    case "likes":
                        commentDd.addClass("liked").removeClass("hated");
                        break;
                    case "despise":
                        commentDd.addClass("hated").removeClass("liked");
                        break;
                }
            }
        }
    };
    //上墙发表
    $(".commentReplyBox .gene_confirm").click(function (e) {
        liveTalk("text", $(".commentReplyBox textarea").val(), $(".commentReplyBox").attr("attrCommentId"), $(".commentReplyBox").attr("tuserid"), 0, 5);
        e.preventDefault();
    });

    //直播点赞
    $(document).on("click", ".liveflower", function () {
        if ($(this).hasClass("on")) { return false; }
        var _self = $(this);
        goodnum = Number($(this).text()),
        speakId = $(this).parents("dd").attr("attr-id");

        $.ajax({
            type: "POST",
            url: baseURL + "/liveajax/InsertPraise",
            data: { zbid: zbvd.zbid, tpid: zbvd.topicid, id: speakId },
            success: function (result) {
                var data = result;
                if (data && data.isok) {
                    _self.addClass("on").text(++goodnum);
                    $(document).minTipsBox({
                        tipsContent: data.Msg,
                        tipsTime: 1
                    });
                }
                else {
                    $(document).minTipsBox({
                        tipsContent: data.Msg,
                        tipsTime: 1
                    });
                }

            },
            error: function (result) {

            }
        });
    });

    //删除直播发言和直播评论
    $(document).on("click", ".delLiveMsg,.btn_revoke", function () {
        var _self = $(this);
        speakId = $(this).parents("dd").attr("attr-id");
        createBy = $(this).parents("dd").attr("attrcreateby");
        $(document).popBox({
            boxContent: "确定撤回吗？",
            btnType: "both",
            confirmFunction: function () {

                imwebsocket.UnDo(speakId, 1);

            }
        });
    });

    $(document).on("click", ".delCommentMsg", function () {
        var _self = $(this);
        commentId = $(this).parents("dd").attr("attr-id");
        createBy = $(this).parents("dd").attr("attrcreateby");
        $(document).popBox({
            boxContent: "确定删除吗？",
            btnType: "both",
            confirmFunction: function () {

                imwebsocket.UnDo(commentId, 0);

            }
        });
    });

    //开始直播
    var livestartbol = true;
    $(".liveStart").click(function () {

        if ("2,3,4".indexOf(zbvd.modeltype) > -1) {
            $(document).popBox({
                boxContent: '<div style="text-align:center;line-height:2.5rem;">\
                             视频直播和语音直播需要使用微赞app<br/><span style="color:red;">在app中开始后这里会自动开始</span><br/><a href="http://vzan.cc/live/appinvitation" style="color:#00acff">您还未安装？点击下载</a></div>',
                btnType: "both",
                confirmFunction: function () {

                }
            });
        }
        else {
            $(document).popBox({
                boxContent: "确定要开始直播吗？",
                btnType: "both",
                confirmFunction: function () {
                    if (livestartbol) {
                        livestartbol = false;
                    } else { return false; }
                    $(".loadingBox").show();


                    $.ajax({
                        type: "POST",
                        url: baseURL + "/liveajax/liveStart",
                        data: { type: "beginTopic", topicId: liveconfig.TopicId },
                        beforeSend: function (request) {
                            request.setRequestHeader("__RequestVerificationToken", token);
                        },
                        dataType: 'json',
                        success: function (data) {
                            $(".loadingBox").hide();
                            if (data && data.isok) {
                                window.location.reload(true);
                            }
                            else {
                                $(document).minTipsBox({
                                    tipsContent: data.Msg,
                                    tipsTime: 1
                                });
                            }
                            livestartbol = true;
                        },
                        error: function () {

                            livestartbol = true;
                        }
                    });
                }
            });
        }
        
    });


    //底部状态
    $(document).on("focus", ".commentInput", function () {
        $(".input_bar").removeClass("bottomTAb_1").addClass("bottomTAb_2");
    }).on("blur", ".commentInput", function () {
        if ($(this).val() == "" || $(this).val() == undefined) {
            $(".input_bar").removeClass("bottomTAb_2").addClass("bottomTAb_1");
        }
    }).on("click", ".btn_tab_audio", function () {
        $(".input_bar").removeClass("bottomTAb_1").addClass("bottomTAb_3");
    }).on("click", ".btn_tab_keyboard", function () {
        $(".input_bar").removeClass("bottomTAb_3").addClass("bottomTAb_1");
    })




    //	播放音频
    var lastPlay,
        isAutoPlay = true,
        _audioPlayer = document.getElementById("audioPlayer"),
        $audioPlayer = $("#audioPlayer"),
        begintime = 0;
    $(document).on("click", ".recordingMsg", function () {
        playAudio($(this));
    });


    function playAudio(isme) {
        var self = isme;
        self.addClass("isReaded");
        rememberImReaded(self.parents("dd").attr("attr-id"));

        if (!self.hasClass("isPlaying")) {
            isAutoPlay = true;
            stopAnime();

            self.addClass("isPlaying");
            //!self.hasClass("loadok")&&
            self.addClass("audioloading");

            var _src = self.find(".audio_info").data("src");
            if (_src != '') {

                $audioPlayer.attr("src", _src);
                _audioPlayer.volume = 1;
                _audioPlayer.play();

                clearInterval(timer);
                timer = setInterval(function () {
                    if (self.hasClass("audioloading") && timercount < 5) {
                        var v = Math.random();
                        $audioPlayer.attr("src", _src + "?v=" + v);
                        timercount += 1;
                        _audioPlayer.volume = 1;
                        _audioPlayer.play();
                    }
                    if (timercount >= 5) {
                        stopAnime();
                        clearInterval(timer);
                        timercount = 0;
                        _audioPlayer.pause();
                        $audioPlayer.removeAttr("src");
                        $(document).minTipsBox({
                            tipsContent: "音频加载失败，请稍后重试",
                            tipsTime: 1
                        })

                    }
                }, 2000);

            }


        } else {
            isAutoPlay = false;
            _audioPlayer.pause();
            $audioPlayer.removeAttr("src");
            clearInterval(timer);
            timercount = 0;
            stopAnime();
        }
    }

    function stopAnime() {
        if ($(".isPlaying").length > 0) {
            $(".isPlaying").removeClass("isPlaying").removeClass("audioloading");
        }

    }

    _audioPlayer.loop = false;
    //canplay
    _audioPlayer.addEventListener('canplay', function () {
        imdebug && console.log("audio canplay");
    }, false);


    var timer;
    var timercount = 0;
    //可以播放的时候 去掉加载状态
    _audioPlayer.addEventListener("canplaythrough", function (a) {
        imdebug && console.log("audio canplaythrough readyState:" + _audioPlayer.readyState + " duration:" + _audioPlayer.duration);
    }, !1);
    //尝试获取媒体数据，但数据不可用时触发。  
    _audioPlayer.addEventListener("stalled", function (a) {
        imdebug && console.log("audio stalled");
        0 < $(".audioloading").length && 1 > _audioPlayer.currentTime && $audioPlayer.attr("src", $(".isPlaying").find("audio").attr("src"))
    }, !1);
    //暂停的时候移除所有状态

    _audioPlayer.addEventListener("pause", function () {
        imdebug && console.log("audio pause duration:" + _audioPlayer.duration);
    }, !1)
    _audioPlayer.addEventListener('ended', function () {
        imdebug && console.log("audio ended");

        //重新查找未播放语音 
        var sendType = inputMode; //$(".header_tab a.on").attr("name");

        //所有语音,未播放语音,最后一个播放的语音的位置
        var audioList, notPlayAudioList, currentIndex;
        switch (sendType) {
            case "live":
                audioList = $("#speakBox .recordingMsg");
                break;
            case "comment":
                audioList = $("#commentBox .recordingMsg");
                break;
        }
        notPlayAudioList = audioList.not(".isReaded");
        currentIndex = audioList.index($(".isPlaying"));
        //获取到索引再停止
        stopAnime();
        //如果还有未播放的 
        if (audioList && audioList.length > 0 && notPlayAudioList.length > 0 && currentIndex != -1) {
            //var nextAudio = audioList.eq(currentIndex + 1);
            var ci = currentIndex;
            while (ci + 1 < audioList.length) {
                ci += 1;
                var caudio = audioList.eq(ci);
                if (!caudio.hasClass("isReaded")) {
                    playAudio(caudio);
                    break;
                }

            }

        }

    }, false);
    //Error
    _audioPlayer.addEventListener('error', function () {
        imdebug && console.log("audio error");
    }, false);
    //playing
    _audioPlayer.addEventListener('playing', function () {
        $(".isPlaying").removeClass("audioloading").addClass("loadok");
        clearInterval(timer);
        timercount = 0;
        imdebug && console.log("audio playing");
    }, false);
    //记录已播放音频
    var recordReaded = {};

    if (localStorage.getItem('recordReaded')) {
        recordReaded = JSON.parse(localStorage['recordReaded']);
    }

    function imReaded(id) {
        if (recordReaded[id]) {
            $("dd[attr-id=" + id + "]").find(".recordingMsg").addClass("isReaded");
        }
    }

    function rememberImReaded(id) {
        if (!recordReaded[id]) {
            recordReaded[id] = new Date().getTime();
            localStorage.setItem('recordReaded', JSON.stringify(recordReaded));
        }
    }





    //  直播提问
    $(".liveAsk").on("click", function () {
        //$(".askTypeBox").toggle();
        var asktype = "1";//$(this).attr("type-name");
        $(".commentaskBox .gene_confirm").attr("typename", asktype);
        if (asktype == "Y") {
            $(".commentaskBox .reply_textarea").attr("placeholder", "请输入问题内容");
        } else {
            $(".commentaskBox .reply_textarea").attr("placeholder", "请输入评论内容");
        }
        $(".commentaskBox").show();
    });
    $(".askTypeBox a").on("click", function () {
        var asktype = $(this).attr("type-name");
        $(".commentaskBox .gene_confirm").attr("typename", asktype);
        if (asktype == "Y") {
            $(".commentaskBox .reply_textarea").attr("placeholder", "请输入问题内容");
        } else {
            $(".commentaskBox .reply_textarea").attr("placeholder", "请输入评论内容");
        }
        $(".commentaskBox").show();
    });
    $(".commentaskBox .gene_confirm").click(function () {
        //commentWall("text",$(".commentaskBox .reply_textarea").val(),$(this).attr("typename")); 
        imwebsocket.commentWall("text", $(".commentaskBox .reply_textarea").val(), $(this).attr("typename"));
        $(".commentaskBox").hide();
        $(".commentaskBox .reply_textarea").val("");
    });
    $(".commentaskBox .gene_cancel").click(function () {
        $(".askTypeBox").hide();
    });


    function rewardactionHandle(data) {
        if ($(".luckyMoney[attr-id='" + data.id + "']").length > 0) {
            $(".luckyMoney[attr-id='" + data.id + "']").find(".talkContent").attr("attr-response", data.rewardResponse);
        }
    }


    /!*************************赞赏******************************************!/
    $(document).on("click", ".speaker_shang a,.btn_ilike,.guest_list .guest_img,.shangzhubo", function () {
        if (isiOS() || isAndroid()) {
            if (!$(this).hasClass("shangzhubo")) {
                var parent = $(this).closest("dd");
                //直播区赏
                if (parent.hasClass("left_bubble")) {
                    var shangid = parent.attr("attrcreateby");
                    var name = parent.find(".speaker_name b").html();
                    var userImg = parent.find(".head_portrait img").attr("src");
                    $(".live_headpic img").attr("src", userImg)
                    $(".live_towho").attr("shangid", shangid);
                    $(".live_towho").text(name);
                    $(".live_towho").attr("parentid", "");
                    $(".redbagBox").show();
                }//评论区赏
                else if (parent.hasClass("comment_dd")) {
                    var shangid = parent.attr("attrcreateby");
                    var name = parent.find(".author_name").html();
                    var userImg = parent.find(".avatar img").attr("src");
                    $(".live_headpic img").attr("src", userImg)
                    $(".live_towho").attr("shangid", shangid);
                    $(".live_towho").attr("parentid", parent.attr("attr-id"));
                    $(".live_towho").text(name);
                    $(".redbagBox").show();
                }//更多区
                else if (parent.parent().hasClass("guest_list")) {
                    var shangid = parent.attr("attrcreateby");
                    var name = parent.find(".guest_title_1").html();
                    var userImg = parent.find(".guest_img img").attr("src");
                    $(".live_headpic img").attr("src", userImg)
                    $(".live_towho").attr("shangid", shangid);
                    $(".live_towho").attr("parentid", "");//不传onwall=true
                    $(".live_towho").text(name);
                    $(".redbagBox").show();
                }
            }
            else {
                //语音赏主播
                $(".live_headpic img").attr("src", $(this).data("hostimg"))
                $(".live_towho").attr("shangid", $(this).data("hostuserid"));
                $(".live_towho").attr("parentid", "");//不传onwall=true
                $(".live_towho").text($(this).data("hostname"));
                $(".redbagBox").show();
            }

        } else {
            $(document).popBox({
                boxContent: "请使用手机微信赞赏",
                btnType: "confirm",
                confirmName: "知道了"
            });
        }
    });

    var redbagbol = true;
    $(document).on("click", ".live_redbaglist li", function () {
        var pageid = $(".live_towho").attr("shangid");
        var parentid = $(".live_towho").attr("parentid");
        var pagemoney = Number($(this).find("var").text());
        //if (Number(pagemoney) < 1) {
        //    $(document).minTipsBox({
        //        tipsContent: "请输入大于1元的金额",
        //        tipsTime: 1
        //    });
        //    return false;
        //} else if (Number(pagemoney) > 100) {
        //    $(document).minTipsBox({
        //        tipsContent: "请输入小于100的金额",
        //        tipsTime: 1
        //    });
        //    return false;
        //}
        var pagemoney = pagemoney * 100;
        liveRedbag("redpacket", pagemoney, pageid, zbvd.zbid, zbvd.topicid, parentid);
    });

    //赞赏弹框
    $(document).on("click", ".live_othermoney", function () {
        $(".otherRedmoneyBox").show();
    }).on("click", ".otherRedmoneyBox", function (et) {
        if (et.target.className == "redbag_count_label" || et.target.className == "money_count" || et.target.className == "gene_btn gene_confirm") {
            return false;
        }
        $(".otherRedmoneyBox").hide();
    });

    $(document).on("click", ".otherRedmoneyBox .gene_confirm", function () {
        var pagemoney = Number($(".money_count").val());
        var pageid = $(".live_towho").attr("shangid");
        if (pagemoney == "") {
            $(document).minTipsBox({
                tipsContent: "金额不能为空",
                tipsTime: 1
            });
            return false;
        } else if (!/(^[0-9]*\.[0-9]*$)|(^[0-9]*$)/.test(pagemoney)) {
            $(document).minTipsBox({
                tipsContent: "请输入数字!",
                tipsTime: 1
            });
            return false;
        }
        else if (Number(pagemoney) < 1) {
            $(document).minTipsBox({
                tipsContent: "请输入大于1的金额",
                tipsTime: 1
            });
            return false;
        }
        else if (Number(pagemoney) > 100) {
            $(document).minTipsBox({
                tipsContent: "请输入小于100的金额",
                tipsTime: 1
            });
            return false;
        }
        pagemoney = (pagemoney * 100).toFixed(0);
        liveRedbag("redpacket", pagemoney, pageid, zbvd.zbid, zbvd.topicid);
        $(".otherRedmoneyBox").hide();
    });

    //	直播赞赏提交
    function liveRedbag(type, pagemoney, pageid, liveId, topicId, parentid) {
        if (redbagbol) {
            redbagbol = false;
            var dbjson = { byUserId: pageid, total_fee: pagemoney, liveId: liveId, topicId: topicId, parentid: parentid };
            $.ajax({
                type: "POST",
                url: baseURL + "/live/PayCenter?t=1",
                data: dbjson,
                success: function (result) {
                    if (result.isok && result.Msg != null) {
                        callPay(result.Msg, dbjson);
                    }
                    else {
                        $(document).minTipsBox({
                            tipsContent: result.Msg,
                            tipsTime: 1
                        });
                        redbagbol = true;
                    }
                },
                error: function () {
                    redbagbol = true;
                    $(document).minTipsBox({
                        tipsContent: 'error',
                        tipsTime: 1
                    });
                }
            });
        }
    }

    function callPay(data, frmdata) {
        if (typeof WeixinJSBridge == "undefined") {
            if (document.addEventListener) {
                document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
            } else if (document.attachEvent) {
                document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
            }
        } else {
            onBridgeReady(data, frmdata);
        }
    }
    function onBridgeReady(data, frmdata) {
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest',
            JSON.parse(data),
            function (res) {
                if (res.err_msg == "get_brand_wcpay_request:ok") {
                    $(document).minTipsBox({
                        tipsContent: "赞赏成功",
                        tipsTime: 1
                    });
                    $(".redbagBox").hide();
                    moveToEnd($("#speakBox"), true);
                    $(".QRcodePay").hide();
                }
                else if (res.err_msg != "get_brand_wcpay_request:cancel") {//支付失败，自动却换成二维码支付
                    setTimeout(function () { jsNaticeCall(frmdata) }, 500);
                }
                //else if (res.err_msg == "get_brand_wcpay_request:cancel") {
                //    $(document).minTipsBox({
                // 		tipsContent:"已取消赞赏", 
                // 		tipsTime:1
                // 	});
                //}
                redbagbol = true;
                // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。 
            }
        );
    }

    function jsNaticeCall(frmdata) {
        $(document).minTipsBox({
            tipsContent: "准备付款",
            tipsTime: 1
        });

        $.ajax({
            type: "POST",
            url: baseURL + "/live/PayCenter?t=2",
            data: frmdata,
            dataType: "json",
            success: function (data) {
                if (data.isok) {
                    $(".redbagBox").hide();
                    $("#payqrcode").attr("src", "/live/nt?data=" + data.Msg);
                    $(".QRcodePay").show();
                } else {
                    $(document).minTipsBox({
                        tipsContent: data.Msg,
                        tipsTime: 1
                    });
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $(document).minTipsBox({
                    tipsContent: "支付失败",
                    tipsTime: 1
                });
            }
        });
    }

    //   赞赏弹框
    $(document).on("click", ".live_otherPay", function () {
        $(".QRcodePay").show();
    }).on("click", ".QRcodePay", function (et) {
        if (et.target.className == "redbag_count_label" || et.target.className == "money_count" || et.target.className == "gene_btn gene_confirm") {
            return false;
        }
        $(".QRcodePay").hide();
    });

    var whogive = "", whoget = "", response = "", detailbol = true;
    $(document).on("click", ".luckyMoney .lm_main:not(.redbaginfo)", function () {
        $(".LmTipsBox").attr("attr-id", $(this).parents(".luckyMoney").attr("attr-id"));
        $(".live_headpic img").attr("src", $(this).data("imgurl"));
        $(".thank_money var").text(Number($(this).data("money")) / 100);
        response = $(this).data("response");
        whogive = $(this).find("var").eq(0).text();
        whoget = $(this).find("var").eq(1).text();
        $(".replyresult .r1").text(whoget);
        $(".replyresult .r2").text(whogive);
        $(".LmTipsBox .live_towhy").html(whogive + "<var>赞赏了</var>" + whoget);
        if (response != "" && response != "null") {
            if (response == "baobao") {
                $(".replyresult .r3").text("拥抱");
            } else if (response == "loveyou") {
                $(".replyresult .r3").text("握手");
            } else if (response == "meme") {
                $(".replyresult .r3").text("么么哒");

            }
            $(".replyresult").show();
            $(".thankBox").hide();
        } else {
            $(".replyresult").hide();
            $(".replyresultNone").show();
            if ($(this).data("myself") == "true") {
                $(".LmTipsBox .live_towhy").html(whogive + "<var>赞赏了</var>你");
                $(".thankBox").show();
                $(".rgdetail").show();
            }
        }

        //if (userRole == "creater" || userRole == "manager" || $(this).attr("attr-myself") == "true") {
        //    $(".rgdetail").show();
        //    $(".redbag_rule_2").show();
        //    if ($(this).attr("attr-myself") == "true") {
        //        $(".redbag_rule_2").hide();
        //        $(".redbag_rule_3").show();
        //    }
        //}
        $(".rgdetail").show();
        $(".redbag_rule_2").show();
        if ($(this).data("myself") == "true") {
            $(".redbag_rule_2").hide();
            $(".redbag_rule_3").show();
        }


        $(".thank_money").show();
        if ($(this).attr("data-money") == "" || $(this).attr("data-money") == "null" || $(this).attr("data-money") == undefined) {
            $(".thank_money").hide();
        }


        $(".LmTipsBox").show();
    }).on("click", ".thank_choose dd", function () {
        var action = $(this).attr("attr-action");
        var $this = $(this);
        $.ajax({
            type: "POST",
            url: baseURL + "/live/speak/addAction.htm",
            data: { topicId: topicId, speakId: $(".LmTipsBox").attr("attr-id"), action: action },
            success: function (result) {
                var data = eval("(" + result + ")");
                if (data.statusCode == "200") {
                    rewardactionHandle(data.liveSpeakView);
                    $(".replyresult").show();
                    $(".thankBox").hide();
                    $(".replyresult .r1").text(whoget);
                    $(".replyresult .r2").text(whogive);
                    $(".replyresult .r3").text($this.html());
                } else {
                    alert(false);
                }

            },
            error: function () {
                alert(false);
            }
        });
    }).on("click", ".rgdetail .rglist", function () {

        if (detailbol) {
            detailbol = false;
            $(this).parent(".rgdetail").addClass("on");
        } else {
            detailbol = true;
            $(this).parent(".rgdetail").removeClass("on");
        }
        $(".managerThankBox").slideToggle();

    });
    $(document).on("click", ".LmTipsBox", function (et) {
        if (et.target.className == "rglist") {
            return false;
        } else
            $(this).hide();
        $(".managerThankBox").hide();
        $(".rgdetail").hide();
        $(".replyresultNone").hide();
        $(".redbag_rule_3").hide();
        detailbol = true;
        $(".rgdetail").removeClass("on");
    });
    $(document).on("click", ".redbagBox", function (et) {
        if (et.target.className == "rglist") {
            return false;
        } else
            $(this).hide();
    });


    //预览图片
    function viewImg(imgThis, n) {
        var thisSrc = imgThis.attr("src");
        var imgSrcList = [];

        if (n == 0) {
            var imgList = $("#liveMainBox #speakBubbles img[fullsrc]")
            for (i = 0; i < imgList.length; i++) {
                imgSrcList[i] = imgList.eq(i).attr("src");//.replace(/(@)\w*!/, "@1600w_1l_2o");
            }
        }
        else if (n == 1) {
            var imgList = $("#commentBox #commentDl img[fullsrc]");
            for (i = 0; i < imgList.length; i++) {
                imgSrcList[i] = imgList.eq(i).attr("src");//.replace(/(@)\w*!/, "@1600w_1l_2o");
            }
        }

        wx.previewImage({
            current: thisSrc,
            urls: imgSrcList
        });
    };

    $(document).on("click", "#liveMainBox #speakBubbles img[fullsrc]", function () {
        viewImg($(this), 0);
    });

    $(document).on("click", "#commentBox #commentDl img[fullsrc]", function () {
        viewImg($(this), 1);
    });

    $("#loginbtn").click(function () {
        var topicid = parseInt($(this).attr("topicid")) || 0;
        var actionName = $(this).data("actionname") || "";
        if (topicid == 0 || IsNullOrEmpty(actionName)) {
            return;
        }
        window.location = baseURL + "/live/" + actionName + "-" + topicid + "?types=oauths";
    })

    /!*录音参数 begin*!/
    var recordingSecond = 0, maxSecondLength = 58;
    var recordingTimer;
    //var btnOffsetTop = document.getElementById('speakBottom').offsetTop - document.getElementById('btnRecording').offsetTop;
    var O = 0;
    document.getElementById("speakBottom") && (O = $(".recording_tab_box").height() + $(".speakBottom").height());
    var isTouching = true;
    var changeModeTips = true, z = !0, A = !1;
    //持续录音模式
    var continuousRecording = false;
    function clock() {
        recordingSecond++;
        
        //60 < recordingSecond && (recordingSecond = 60);
        //如果规定时间没有手动停止，开启持续录音 只有点击模式才会开启持续录音模式
        if (recordingSecond > maxSecondLength) {
            recordingSecond = maxSecondLength;
            $(".second_dd var").text(recordingSecond);
            //清除定时器
            clearInterval(recordingTimer);
            //点击模式下
            if ($(".recording_tab_box").hasClass("clickRecording")) {
                $("#btnStopRec").click();
                continuousRecording = true;
            }
        }
        else {
            $(".second_dd var").text(recordingSecond);
        }

    }*/
    var isRecording = true;
    var isRecordingStart = false;
    var isRecordSent = true;
    var isTouching = true;

    var K = "";//点击模式下 录音的serverid;
    /*录音参数 end*/
    //评论区最后一次滚动位置
    var lastCommentScrollPosition = 0;
    //是否第一次点击评论
    var isFommentFirstShow = true;

    //双模式输入框
    function resetBottom() {
        $("body").removeClass("textBottom").removeClass("voiceBottom").removeClass("othersBottom").removeClass("hasTabBottom").removeClass("qqfaceBottom");

    }
    function G() {
        0 < $(".isPlaying").length && $(".isPlaying").removeClass("audioloading").removeClass("isPlaying")
    }
    function B() {
        $(".recording_click .btn_dd").removeClass("stopRec").removeClass("startRec")
    }
    function sendTxtMsg(e) {
        //var tab = $(".header_tab a.on").attr("name");
        var val = $(".speakInput").val();
        switch (inputMode) {
            case "live":
                liveTalk("text", val, "", 0, 0, 1);
                break;
            case "comment":
                imwebsocket.commentWall("text", val, "", 0, 0, 1);
                break;
        }
        $(".speakInput").focus();
        //e.preventDefault();
    }
    function stopPropagation(e) {
        if (e.stopPropagation)
            e.stopPropagation();
        else
            e.cancelBubble = true;
    }
    //点击页面任意位置隐藏输入区域
    $(document).click(function () {
        $("body").hasClass("voiceBottom") ? (resetBottom(), $("body").addClass("hasTabBottom")) : "";
        $("body").hasClass("othersBottom") ? (resetBottom(), $("body").addClass("hasTabBottom")) : "";
        $("body").hasClass("qqfaceBottom") ? (resetBottom(), $("body").addClass("hasTabBottom")) : "";
        $(".manage_container").hide();
    });
    //allbind
    $(document)
        //语音
        /*.on("click", ".tab_voice,.btnInputVoice", function (e) {
            if (isWX()) {
                $("body").hasClass("voiceBottom") ? (resetBottom(), $("body").addClass("hasTabBottom")) : (resetBottom(), $("body").addClass("voiceBottom"));
                //$(document).scrollTop($(document).height());
                stopPropagation(e);
            }
            else {
                $(document).popBox({
                    boxContent: "请使用手机微信发语音！",
                    btnType: "confirm",
                    confirmName: "知道了"
                });
            }
        })
        //返回
        .on("click", ".btnBackVoice", function () {
            resetBottom();
            $("body").addClass("hasTabBottom")
        })
        //文字
        .on("click", ".tab_text", function () {
            resetBottom();
            $("body").addClass("textBottom").click().focus();
        })
        //文字发送
        .on("click", ".btnLiveTalk", function (e) {
            sendTxtMsg($(this));
            $("body").attr("class", "nobottom hasTabBottom");
            stopPropagation(e);

        }).on("keydown", function (event) {
            var e = event || window.event || arguments.callee.caller.arguments[0];
            if (e && e.keyCode == 13 && ($("body").hasClass("qqfaceBottom") || $("body").hasClass("hasTabBottom"))) {
                if ((zbvd.block || zbvd.blockall)) {
                    e.stopPropagation();
                }
                sendTxtMsg($(this));
            }
        })
        //其他
        .on("click", ".tab_others", function (e) {
            $("body").hasClass("othersBottom") ? (resetBottom(), $("body").addClass("hasTabBottom")) : (resetBottom(), $("body").addClass("othersBottom"));
            $(document).scrollTop($(document).height() - $(window).height());
            stopPropagation(e);
        })
        //其他2
        .on("click", ".btnInputMore", function (e) {
            $("body").hasClass("othersBottom") ? (resetBottom(), $("body").addClass("hasTabBottom")) : (resetBottom(), $("body").addClass("othersBottom"));
            //$(document).scrollTop($(document).height() - $(window).height());
            stopPropagation(e);
        })
        //表情*/
        .on("click", ".btnQQface", function (e) {
            $("body").hasClass("qqfaceBottom") ? (resetBottom(), $("body").addClass("hasTabBottom")) : (resetBottom(), $("body").addClass("qqfaceBottom"));
            //$(document).scrollTop($(document).height()-$(window).height());
            stopPropagation(e);
        })
        //点击表情
        .on("click", "#div-qqfaces span", function (e) {

            var val = $(this).find("a").attr("code");
            //$(".speakInput").insertAtCaret(val);
            var preval = $(".speakInput").val();
            $(".speakInput").val(preval + val);
            
            e.stopPropagation();
        })
        //长按录音模式
        .on("click", ".tab_recordingType", function (e) {
            $(".recording_tab_box").toggleClass("clickRecording");
            stopPropagation(e);
        })
        .on("click", ".recording_tab_box", function (e) {
            e.stopPropagation();
        })
        //点击录音
        .on("click", "#btnStartRec", function (e) {
            clearInterval(recordingTimer);
            recordingSecond = 0;
            isRecording && (isRecording = false, wx.startRecord({
                success: function (a) {
                    G();
                    _audioPlayer.pause();
                    B();
                    $(".recording_click .btn_dd").addClass("startRec");
                    $(".speakBottom").addClass("recording_2");
                    $(".recording_click .tips_dd").text("点击按钮，完成录音");
                    recordingSecond = 0;
                    recordingTimer = setInterval(clock, 1000)
                },
                fail: function (a) {
                    recordingSecond = 0;
                    isRecording = true;
                    B();
                }
            }))
            stopPropagation(e);
        })
        //有文字输入时
        .on("input", ".speakInput", function (e) {
            var val = $(this).val();
            if (val != "" && val.trim() != "") {
                $(".btnInputMore").hide();
                $(".btnLiveTalk").show();
            }
            else {
                $(".btnInputMore").show();
                $(".btnLiveTalk").hide();
            }
            stopPropagation(e);
        })
        //文本框
        .on("click focus", ".speakInput", function (e) {
            if (!$("body").hasClass("qqfaceBottom")) {
                $("body").attr("class", "nobottom hasTabBottom");
                var val = $(this).val();
                if (val != "" && val.trim() != "") {
                    $(".btnInputMore").hide();
                    $(".btnLiveTalk").show();
                }
                else {
                    $(".btnInputMore").show();
                    $(".btnLiveTalk").hide();
                }
            }

            stopPropagation(e);
        })
        //文本框失去焦点
        .on("blur", ".speakInput", function (e) {
            var val = $(this).val();
            if (val != "" && val.trim() != "") {
                $(".btnInputMore").hide();
                $(".btnLiveTalk").show();
            }
            else {
                $(".btnInputMore").show();
                $(".btnLiveTalk").hide();
            }
            stopPropagation(e);
        })
        //停止录音
        .on("click", "#btnStopRec", function (e) {
            
            if (recordingSecond < 1) {
                $(document).minTipsBox({
                    tipsContent: "录音时间太短",
                    tipsTime: 1
                })
            }
            else {
                clearInterval(recordingTimer);
                wx.stopRecord({
                    success: function (a) {
                        K = a.localId;
                        B();
                        $(".recording_click .btn_dd").addClass("stopRec");
                        $(".recording_click .tips_dd").text("");
                        //自动发送
                        if (continuousRecording) {
                            //setTimeout(function () {
                            //    $("#btnSentRec").click();
                            //}, 200);
                            $("#btnSentRec").click();
                        }
                    },
                    fail: function (a) {
                        B();
                        isRecording = true;
                        $(".second_dd var").text("0");
                        $(".speakBottom").removeClass("recording_2");
                        $(".recording_click .tips_dd").text("点击按钮录音");
                        $(document).minTipsBox({
                            tipsContent: "录音时间太短",
                            tipsTime: 1
                        })
                    }
                })
            }
            //如果点击停止的时候录音时间<最大时长 关闭自动录音模式
            if (recordingSecond < maxSecondLength) {
                continuousRecording = false;
            }
            stopPropagation(e);
        })
        //发送录音
        .on("click", "#btnSentRec", function (e) {
            "" != K && (wxUploadVoice(K), $(".speakBottom").removeClass("recording_2"), $(".recording_click .tips_dd").text("点击按钮录音"));
            stopPropagation(e);
        })
        //取消录音
        .on("click", "#btnCancelRec", function (e) {
            clearInterval(recordingTimer);
            K = "";
            isRecording = true;
            isRecordSent = true;

            
            recordingSecond = 0;
            $(".recordingSending").hide();
            $(".recordingSending").find("b").html("语音正在发送...");
            $(".second_dd var").text("0");
            $(".speakBottom").removeClass("recording_2");
            $(".recording_click .tips_dd").text("点击按钮录音");
            B();
            stopPropagation(e);
        })
        //图片上传
        .on("click", ".btnImgUpload", function (e) {
            if (IsWeiXinChat && !$(this).hasClass("fileupload")) {
                wx.chooseImage({
                    count: 5,
                    success: function (res) {
                        //记录选择的图片
                        var images = {
                            localId: [],
                            serverId: []
                        };
                        images.localId = res.localIds;

                        var i = 0, length = images.localId.length;
                        images.serverId = [];
                        //上传图片
                        function upload() {
                            wx.uploadImage({
                                localId: images.localId[i],
                                success: function (res) {
                                    i++;
                                    images.serverId.push(res.serverId);
                                    //后台下载获取图片路径
                                    $.ajax({
                                        type: "post",
                                        url: "/liveajax/UploadImagesByWx",
                                        data: { mediaId: res.serverId, zbid: liveconfig.zbId, tpid: liveconfig.TopicId, types: "img" },
                                        dataType: "JSON",
                                        success: function (data) {
                                            if (data && data.isok) {
                                                //发图片消息
                                                switch (inputMode) {
                                                    case "live":
                                                        liveTalk("image", data.imgurl, "", 0, 0, 2);
                                                        break;
                                                    case "comment":
                                                        imwebsocket.commentWall("image", data.imgurl, "", 0, 0, 2);
                                                        break;
                                                }
                                            }
                                            else {
                                                $(document).minTipsBox({
                                                    tipsContent: data.Msg,
                                                    tipsTime: 1
                                                });
                                            }
                                        },
                                        error: function () {
                                            $(document).minTipsBox({
                                                tipsContent: "error",
                                                tipsTime: 1
                                            });
                                        }
                                    });

                                    if (i < length) {
                                        upload();
                                    }
                                },
                                fail: function (res) {
                                    $(document).minTipsBox({
                                        tipsContent: "图片上传失败",
                                        tipsTime: 1
                                    });
                                }
                            });
                        }
                        upload();
                        //隐藏上传按钮
                        $(".tab_others").trigger("click");
                    }
                });
                stopPropagation(e);
            }
            else {
                $("#pcfileUpload").attr("attr-type", $(this).attr("attr-type"));
                $("#pcfileUpload").click();
            }
        })
        /*PC版上传图片*/
        .on("change", "#pcfileUpload", function () {
            if ($("#pcfileUpload").val().length > 0) {
                var _type = $("#pcfileUpload").attr("attr-type");
                var _msgtype = '';
                switch (_type) {
                    case "img":
                        _msgtype = 2;
                        break;
                    case "file":
                        _msgtype = 12;
                        break;
                }
                //console.log(this.files.length)
                //console.log(this.files[0].size)
                if (this.files.length == 1 && this.files[0].size / (1024 * 1024) > 10) {
                    $(document).minTipsBox({
                        tipsContent: "请上传小于10M的文件",
                        tipsTime: 1
                    });
                    return;
                }
                $.ajaxFileUpload(
                {
                    url: '/liveajax/UploadImagesByWx', //用于文件上传的服务器端请求地址
                    secureuri: false, //是否需要安全协议，一般设置为false
                    data: { mediaId: "pcUpload", zbid: liveconfig.zbId, tpid: liveconfig.TopicId, types: $("#pcfileUpload").attr("attr-type") },
                    fileElementId: $('#pcfileUpload'), //文件上传域的ID
                    dataType: 'json', //返回值类型 一般设置为json
                    success: function (data, status)  //服务器成功响应处理函数
                    {
                        if (data && data.isok) {
                            //发图片消息
                            switch (inputMode) {
                                case "live":
                                    liveTalk("image", data.imgurl, "", 0, 0, _msgtype);
                                    break;
                                case "comment":
                                    imwebsocket.commentWall("image", data.imgurl, "", 0, 0, _msgtype);
                                    break;
                            }
                        }
                        else {
                            $(document).minTipsBox({
                                tipsContent: data.Msg,
                                tipsTime: 1
                            });
                        }
                    },
                    error: function (data, status, e)//服务器响应失败处理函数
                    {
                        $(document).minTipsBox({
                            tipsContent: "上传失败！",
                            tipsTime: 1
                        });
                    }
                })
            }
            else {
                $(document).minTipsBox({
                    tipsContent: "请选择上传图片！",
                    tipsTime: 1
                });
            }
            return false;
        })

        //推荐
        .on("click", ".recommended:not(.on),.tjCommentMsg:not(.on),.live_tj:not(.on)", function () {
            var obj = $(this);
            var ids = $(this).closest("dd").attr("attr-id");
            var xhr = $.ajax({
                type: "POST",
                url: baseURL + "/liveajax/asnyforum",
                data: { tpid: zbvd.topicid, id: ids, mid: zbvd.siteid },
                success: function (data) {
                    if (data && data.isok) {
                        $(document).minTipsBox({
                            tipsContent: data.Msg,
                            tipsTime: 1
                        });
                        obj.addClass("on").text("已推荐");
                    }
                    else {
                        $(document).minTipsBox({
                            tipsContent: data.Msg,
                            tipsTime: 1
                        })
                    }
                }
            });
        })
        //拉黑菜单
        .on("click", ".avatar,.speaker_header,.live_lahei,.head_portrait", function () {//
            var roleid = parseInt(zbvd.roleid) || 0;
            if ("1,2,5".indexOf(roleid) == -1 && zbvd.levels != 1) {
                return;
            }
            var uid = $(this).data("uid");
            $("#actionSheet_wrap").show();
            var mask = $('#mask');
            var weuiActionsheet = $('#weui_actionsheet');
            weuiActionsheet.addClass('weui_actionsheet_toggle');
            mask.show()
                .focus()//加focus是为了触发一次页面的重排(reflow or layout thrashing),使mask的transition动画得以正常触发
                .addClass('weui_fade_toggle').one('click', function () {
                    hideActionSheet(weuiActionsheet, mask);
                });
            //设置uid
            $(".weui_actionsheet_menu").attr("uid", uid);

            $('#actionsheet_cancel').one('click', function () {
                //取消uid
                $(".weui_actionsheet_menu").removeAttr("uid", uid);
                hideActionSheet(weuiActionsheet, mask);
            });

            mask.unbind('transitionend').unbind('webkitTransitionEnd');

            function hideActionSheet(weuiActionsheet, mask) {
                weuiActionsheet.removeClass('weui_actionsheet_toggle');
                mask.removeClass('weui_fade_toggle');
                mask.on('transitionend', function () {
                    mask.hide();
                }).on('webkitTransitionEnd', function () {
                    mask.hide();
                });
                $("#actionSheet_wrap").hide();
            }

        })
        //拉黑
        .on("click", ".weui_actionsheet_menu[block] .weui_actionsheet_cell", function () {
            var uid = $(this).closest(".weui_actionsheet_menu").attr("uid");
            uid = parseInt(uid) || 0;

            var _type = $(this).data("type");
            var _state = "";
            var _types = "";
            if (_type == 1) {
                _action = "setuserback";
            }
            else if (_type == 2) {
                _action = "globallock";
                _types = 0;
            }

            if (uid == 0 || _action == "") {
                $(document).minTipsBox({
                    tipsContent: "拉黑失败",
                    tipsTime: 1
                });
                return;
            }
            $.ajax({
                type: "POST",
                url: baseURL + "/liveajax/" + _action,
                data: { id: zbvd.zbid, uid: uid, tpid: zbvd.topicid, types: _types },
                success: function (data) {
                    $(document).minTipsBox({
                        tipsContent: data.Msg,
                        tipsTime: 1
                    });
                }
            });

            var mask = $('#mask');
            var weuiActionsheet = $('#weui_actionsheet');
            weuiActionsheet.addClass('weui_actionsheet_toggle');

            //取消uid
            $(".weui_actionsheet_menu").removeAttr("uid", uid);
            hideActionSheet(weuiActionsheet, mask);


            function hideActionSheet(weuiActionsheet, mask) {
                weuiActionsheet.removeClass('weui_actionsheet_toggle');
                mask.removeClass('weui_fade_toggle');
                mask.on('transitionend', function () {
                    mask.hide();
                }).on('webkitTransitionEnd', function () {
                    mask.hide();
                });
                $("#actionSheet_wrap").hide();
            }
        })
        //取消拉黑
        .on("click", ".weui_actionsheet_menu[unblock] .weui_actionsheet_cell", function () {
            var uid = $(this).closest(".weui_actionsheet_menu").attr("uid");

            var _type = $(this).data("type");
            var _types = "";
            if (_type == 1) {
                _action = "unlock";
            }
            else if (_type == 2) {
                _action = "globallock";
                _types = 1;
            }

            uid = parseInt(uid) || 0;
            if (uid == 0 || _action == "") {
                $(document).minTipsBox({
                    tipsContent: "设置失败",
                    tipsTime: 1
                });
                return;
            }
            $.ajax({
                type: "POST",
                url: baseURL + "/liveajax/" + _action,
                data: { id: zbvd.zbid, uid: uid, tpid: zbvd.topicid, types: _types },
                success: function (data) {
                    $(document).minTipsBox({
                        tipsContent: data.Msg,
                        tipsTime: 1
                    });
                }
            });

            var mask = $('#mask');
            var weuiActionsheet = $('#weui_actionsheet');
            weuiActionsheet.addClass('weui_actionsheet_toggle');

            //取消uid
            $(".weui_actionsheet_menu").removeAttr("uid", uid);
            hideActionSheet(weuiActionsheet, mask);


            function hideActionSheet(weuiActionsheet, mask) {
                weuiActionsheet.removeClass('weui_actionsheet_toggle');
                mask.removeClass('weui_fade_toggle');
                mask.on('transitionend', function () {
                    mask.hide();
                }).on('webkitTransitionEnd', function () {
                    mask.hide();
                });
                $("#actionSheet_wrap").hide();
            }
        })
        //讨论
        .on("click", ".tabToComment,.write_dan_a", function () {
            inputMode = "comment";
            $(".commentBox").show();
            hideBottom();
            //第一次点开 滚动到最底部
            if (isFommentFirstShow) {
                isFommentFirstShow = false;
                moveToEnd($("#commentBox"), true);
            }
            else {
                $("#commentBox").scrollTop(lastCommentScrollPosition);
            }
           
        })
        //回到直播
        .on("click", ".commentHeader", function () {
            inputMode = "live";
            $(".commentBox").hide();
            hideBottom();

        })
        //取消评论
        .on("click", ".danmuBottom .btnCommentCancel,.qlDanmuBg", function () {
            $(".danmuBottom").css({
                "max-height": "0"
            });
            $(".qlDanmuBg").hide();
            $(".danmuInput").blur();
            $(".commentBox").removeClass("typing");
        });
    var be = true;
    $(document)
        .on("click", ".isdan_btn_a", function () {
            if (be) {
                be = false;
                //var a = "";
                var arr_tan = [];
                var cmt1 = $(".comment_dd").eq(-1),
                    cmt2 = $(".comment_dd").eq(-2),
                    cmt3 = $(".comment_dd").eq(-3);
                arr_tan.push(cmt1);
                arr_tan.push(cmt2);
                arr_tan.push(cmt3);
                for (var i = 0; i < arr_tan.length; i++) {
                    var current_node = arr_tan[i];
                    if (current_node.length > 0 && $(".danmulist dd[attr-id='" + current_node.attr("attr-id") + "']").length <= 0) {
                        $(".danmulist").prepend('<dd attr-id="' + current_node.attr("attr-id") + '"><p>' + current_node.find(".content").html() + '</p><i><img src="' + current_node.find(".avatar img").attr("src") + '"></i></dd>');
                    }
                }
                $(".danmu_bar").addClass("on");
                $(".isdan_btn_a").text("关");

                $(".danmuBox").show()
            } else {
                be = true;
                $(".danmu_bar").removeClass("on");
                $(".danmuBox").hide();
                $(".isdan_btn_a").text("弹");
                $(".danmulist").html("");
            }
        })
        .on("click", ".danmuBottom .btnCommentCancel,.qlDanmuBg", function () {
            $(".danmuBottom").css({
                "max-height": "0"
            });
            $(".qlDanmuBg").hide();
            $(".danmuInput").blur();
            $(".commentBox").removeClass("typing")
        })
        //从第一条听
        .on("click", ".justPlayAudio", function () {
            $(".enterLiveTips").hide();
            0 < $("#speakBubbles .recordingMsg").length && ("ended" != liveStatus ? $("#speakBubbles .recordingMsg").last().click() : $("#speakBubbles .recordingMsg").eq(0).click())
        })
        //从第一条看
        .on("click", ".watch_asc", function () {
            //结束的时候按第一条 所以就不响应了
            if (zbvd.watchmode == "" && liveStatus == "ended") {
                $(".enterLiveTips").hide();
            }
            else {
                window.location = baseURL + "/live/liveing-" + zbvd.topicid + "?mode=asc&_t=" + Math.random();
            }

        })
        //从最后一条看
        .on("click", ".watch_desc", function () {
            var _actionname = zbvd.actionname;
            if (IsNullOrEmpty(_actionname)) {
                return;
            }
            //开始的时候是从最后一条 不响应
            if (zbvd.watchmode == "" && liveStatus == "beginning") {
                $(".enterLiveTips").hide();
            }
            else {
                window.location = baseURL + "/live/" + _actionname + "-" + zbvd.topicid + "?mode=desc&_t=" + Math.random();
            }

        });
    //像嘉宾或主持人提问
    $(".cb_top .btn_ask").click(function () {
        $(this).toggleClass("on")
    });


    //点击 管理 同步到论坛
    $(document)
        .on("click", ".linkbtn_manage", function (e) {
            var _container = $(this).find(".manage_container");
            _container.toggle();


            $(".manage_container").not(_container).hide();
            stopPropagation(e);
        })
        //关闭进入提示
        .on("click", ".close_elt", function (e) {
            $(".enterLiveTips").hide();
        });


    //录音 touchstart
    /*document.getElementById('btnRecording').addEventListener('touchstart', function (e) {
        e.preventDefault();
        if (!(isAndroid() || isiOS()) || $("#speakBottom").length <= 0) {
            $(document).minTipsBox({
                tipsContent: "请到手机端录音",
                tipsTime: 1
            })
        }
        imdebug && console.log("touchstart");
        if (changeModeTips) {
            changeModeTips = false;
            $(document).minTipsBox({
                tipsContent: "如果不能按住说话，请切换至点击录音模式",
                tipsTime: 3
            })
        }
        isTouching = true;
        if (isRecording && isRecordSent) {
            wx.startRecord({
                success: function (res) {
                    stopAnime();
                    _audioPlayer.pause();

                    if (isTouching) {
                        isRecordingStart = true;
                        isRecording = false;
                        $("#btnRecording").addClass("on");
                        $(".speakBottom").addClass("recording");
                        $(".recording_box .tips_dd").text("松开发送");

                        recordingSecond = 0;
                        recordingTimer = setInterval(clock, 1000);
                    } else {
                        wx.stopRecord({
                            complete: function (res) {
                                isRecording = true;
                            }
                        });

                    }
                }
            });
        }
        stopPropagation(e);
    });
    document.getElementById("btnRecording").addEventListener("touchmove", function (a) {
        imdebug && console.log("touchmove");
        0 == $(".clickRecording").length && (a.changedTouches[0].clientY >= O ? ($(".recordingTips_2").hide(), $(".recording_box .tips_dd").text("松开发送")) : ($(".recordingTips_2").show(), $(".recording_box .tips_dd").text("松开取消")))
    });
    //录音 touchend
    document.getElementById("btnRecording").addEventListener("touchend", function (a) {
        imdebug && console.log("touchend");
        if (0 == $(".clickRecording").length) {
            isTouching = false;
            $(".speakBottom").removeClass("recording");
            $(".recordingTips_2").hide();
            $(".recording_box .tips_dd").text("按住说话");
            $("#btnRecording").removeClass("on");
            $(".second_dd var").text("0");

            if (isRecordingStart) {
                var b, c = a.changedTouches[0].clientY;
                clearInterval(recordingTimer);
                1 > recordingSecond ? ($(document).minTipsBox({
                    tipsContent: "录音时间太短",
                    tipsTime: 1
                }), wx.stopRecord({
                    complete: function (a) { }
                }), isRecording = true, isRecordingStart = false) : wx.stopRecord({
                    success: function (a) {
                        b = a.localId;
                        c >= O ? wxUploadVoice(b) : $(document).minTipsBox({
                            tipsContent: "已取消发送",
                            tipsTime: 1
                        })
                    },
                    complete: function (a) {
                        isRecording = !0;
                        isRecordingStart = false;
                    }
                })
            }
            else {
                wx.stopRecord();
                isRecording = true;
            }
        }
    });

    function wxUploadVoice(localId) {
        isRecordSent = false;
        clearInterval(recordingTimer);
        wx.uploadVoice({
            localId: localId,
            isShowProgressTips: 1,
            success: function (res) {
                var serverId = res.serverId;
                $(".recordingSending").show();

                $.ajax({
                    type: "post",
                    url: "/live/uploadRecordred",
                    data: { mediaId: res.serverId, voiceTime: recordingSecond, zbid: zbvd.zbid, topicid: zbvd.topicid },
                    dataType: "JSON",
                    success: function (data) {
                        if (data && data.isok) {
                            //为了防止发送之前数据被改写 使用闭包
                            (function (data, recordingSecond) {
                                switch (inputMode) {
                                    case "live":
                                        liveTalk("audio", data.msg, "", 0, recordingSecond, 3);
                                        break;
                                    case "comment":
                                        imwebsocket.commentWall("audio", data.msg, "", 0, recordingSecond, 3);
                                        break;

                                }

                            })(data, recordingSecond);

         

                            
                            $(".recordingSending").find("b").html("发送成功！");

                            setTimeout(function () {

                                //上传后重置状态 
                                $("#btnCancelRec").trigger("click");
                                //如果开启了持续录音模式  自动点击
                                if (continuousRecording) {
                                    
                                    $("#btnStartRec").click();
                                }
                            },1000);

                           

                        }
                        else {
                            $(".recordingSending").find("b").html(data.msg);
                            
                            setTimeout(function () {
                                $("#btnCancelRec").click();
                            }, 1000);
                           
                            

                        }
                    },
                    error: function () {
                        alert("语音上传失败，请重试！");
                        $("#btnCancelRec").click();

                    }
                });
            }
        });
        if (isiOSBoolean) {
            wx.playVoice({
                localId: localId // 需要播放的音频的本地ID，由stopRecord接口获得
            });
            wx.stopVoice({
                localId: localId // 需要停止的音频的本地ID，由stopRecord接口获得
            });
        }
    }

    document.addEventListener('touchcancel', function (e) {
        //imdebug && console.log("touchcancel");
        isTouching = false;
    });

    wx.ready(function () {
        wx.onVoiceRecordEnd({
            // 录音时间超过一分钟没有停止的时候会执行 complete 回调
            complete: function (res) {
                clearInterval(recordingTimer);
                recordingSecond = 60;
                $(".speakBottom").removeClass("recording").removeClass("recording_2");
                $(".recordingTips_2").hide();
                $("#btnRecording").removeClass("on");
                isRecordingStart = false;
                isRecording = true;

                wxUploadVoice(res.localId)
            }
        });
    });

    $(".recordingMsg").each(function () {
        imReaded($(this).closest("dd").attr("attr-id"));
    });

    //检查输入状态 最新消息加弹幕
    setInterval(function () {
        var val = $(".speakInput").val();
        if (val != "" && val.trim() != "") {
            $(".btnInputMore").hide();
            $(".btnLiveTalk").show();
        }
        else {
            $(".btnInputMore").show();
            $(".btnLiveTalk").hide();
        }
        //弹幕

    }, 500);*/

    //微信以外的客户端使用相册查看插件
    //if (!isWX()) {
    //    (function (window, $, PhotoSwipe) {
    //        $(document).ready(function () {
    //            bindPhotoSwipe();
    //        });
    //    }(window, window.jQuery, window.Code.PhotoSwipe));
    //}



});

