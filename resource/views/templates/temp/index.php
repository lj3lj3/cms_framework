<HTML>
<head>
    <meta charset="UTF-8">
    <script src="/js/jquery.js"></script>
    <script src="/js/temp/temp.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
            -webkit-text-size-adjust: none;
        }

        html {
            font-size: 10px;
        }

        body {
            background-color: #f5f5f5;
            font-size: 1.2em;
        }

        .header {
            height: 44px;
            line-height: 44px;
            border-bottom: 1px solid #ccc;
            background-color: #eee;
        }

        .header h1 {
            text-align: center;
            font-size: 2rem;
            font-weight: normal;
        }

        .content {
            background-color: #fff;
        }

        .content .item {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            -webkit-box-align: center;
            box-align: center;
            -webkit-align-items: center;
            align-items: center;
            padding: 3.125%;
            border-bottom: 1px solid #ddd;
            color: #333;
            text-decoration: none;
        }

        .content .item img {
            display: block;
            width: 40px;
            height: 40px;
            border: 1px solid #ddd;
        }

        .content .item h3 {
            display: block;
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            -ms-flex: 1;
            flex: 1;
            width: 100%;
            max-height: 40px;
            overflow: hidden;
            line-height: 20px;
            margin: 0 10px;
            font-size: 1.2rem;
        }

        .content .item .date {
            display: block;
            height: 20px;
            line-height: 20px;
            color: #999;
        }

        .opacity {
            -webkit-animation: opacity 0.3s linear;
            animation: opacity 0.3s linear;
        }

        @-webkit-keyframes opacity {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes opacity {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
<div class="change-line pull-right"></div>

<div class="modal-body text-center" id="chang-line-select" style="display:none;">
    <div class="modal-header">
        <h4 class="modal-title"><img src="//cnstatic01.e.vhall.com/static/img/mobile/change_line_black.png">线路切换</h4>
    </div>

    <li class="active " url="http://cnhlslivepc3.e.vhall.com/vhall/stream/livestream.m3u8"><a href="javascript:;">线路1 (CNHL)</a></li>
    <li class="" url="http://xydislivepc01.e.vhall.com/vhall/stream/livestream.m3u8"><a href="javascript:;">线路2 (XYHL)</a></li>
    <li class="" url="http://cchlslivepc03.e.vhall.com/vhall/stream/index.m3u8"><a href="javascript:;">线路3 (CCHL)</a></li>
</div>

one line

</div>
<div>
    <ul id="ul-load">
        <li>

        </li>
        <li id="load">
            暂无数据
        </li>
    </ul>
</div>
</body>
</HTML>