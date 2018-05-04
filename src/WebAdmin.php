<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>短网址</title>
</head>
<style>
    body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, code, form, fieldset, legend, input, textarea, p, blockquote, th, td {
        margin: 0;
        padding: 0
    }

    table {
        border-collapse: collapse;
        border-spacing: 0
    }

    fieldset, img {
        border: 0;
        vertical-align: top
    }

    address, caption, cite, code, dfn, em, strong, th, var {
        font-style: normal;
        font-weight: normal
    }

    ol, ul {
        list-style: none
    }

    caption, th {
        text-align: left
    }

    h1, h2, h3, h4, h5, h6 {
        font-size: 100%;
        font-weight: normal
    }

    q:before, q:after {
        content: ''
    }

    abbr, acronym {
        border: 0;
        font-variant: normal
    }

    sup {
        vertical-align: text-top
    }

    sub {
        vertical-align: text-bottom
    }

    input, textarea, select {
        font-family: inherit;
        font-size: inherit;
        font-weight: inherit
    }

    input, textarea, select {
        *font-size: 100%
    }

    legend {
        color: #000
    }

    body {
        text-align: center;
        background: #fff;
        font: 12px Tahoma, simsun, arial;
        color: #333
    }

    .container {
        text-align: left;
        width: 508px;
        margin: 0 auto
    }

    .header {
        padding: 200px 0 30px
    }

    .header_logo {
        display: block;
        width: 135px;
        height: 60px;
        margin: 0 auto
    }

    .tab_title {
        overflow: hidden;
        height: 27px;
        padding: 0 40px 1px 20px;
        margin-bottom: 20px;
        background: url("../static/img.png") no-repeat 0 -70px
    }

    .tab_select {
        float: left
    }

    .tab_other {
        float: right
    }

    .tab_select li, .tab_other li {
        float: left
    }

    .tab_select li {
        margin-right: 5px;
        _overflow: hidden
    }

    .tab_select li a, .tab_other li a, .tab_select li span {
        display: block;
        height: 26px;
        line-height: 27px;
        font-size: 14px;
        text-decoration: none;
        cursor: pointer
    }

    .tab_select li a, .tab_select li span {
        background: url("../static/img.png") -527px 0;
        color: #2559a5;
        _float: left
    }

    .tab_select li a {
        padding-left: 3px
    }

    .tab_select li span {
        background-position: right 0;
        padding: 0 20px 0 17px
    }

    .tab_select li.on a, .tab_select li.on span {
        height: 28px
    }

    .tab_select li.on a {
        background-position: -527px -33px;
        position: relative
    }

    .tab_select li.on span {
        background-position: right -33px;
        font-weight: 700
    }

    .tab_other li a {
        margin-left: 4px;
        color: #999;
        display: inline-block
    }

    .tab_other li span.split {
        color: #999;
        font-size: 12px;
        padding-left: 4px
    }

    .url_send {
        margin-top: 10px;
        text-align: right;
        padding-right: 18px
    }

    .send_button, .send_button span {
        text-decoration: none;
        cursor: pointer;
        display: inline-block;
        height: 28px;
        color: #fff;
        font-weight: 700;
        line-height: 28px;
        overflow: hidden;
        background: url("../static/img.png") -527px -69px
    }

    .send_button {
        padding-left: 5px
    }

    .send_button span {
        background-position: right -69px;
        padding: 0 15px 0 10px
    }

    .url_alias input {
        width: 54px;
        outline: 0;
        height: 18px;
        padding: 0 3px;
        border: 1px solid #ccc;
        box-shadow: 1px 1px 5px #ccc inset
    }

    .alias_tip {
        color: #ccc
    }

    .tab_body {
        padding: 0 20px
    }

    .url_input {
        width: 448px;
        height: 28px;
        padding: 2px 0 0 2px;
        margin: 10px 0;
        background: url("../static/img.png") no-repeat 0 0
    }

    .url_input input {
        outline: 0;
        width: 432px;
        height: 17px;
        font-size: 14px;
        padding: 4px 5px 0;
        border: 0
    }

    .url_revert {
        display: none
    }

    .footer {
        padding: 80px 0 0;
        color: #06a
    }


    /*logo*/
    .text-reflect-base{
        color: palegreen;
        -webkit-box-reflect:below 10px;
    }
    .text{
        width: 300px;
        height: 50px;
        top: 150px;
        position: absolute;
        left: 50%;
        margin-left: -70px;
        background-image: -webkit-linear-gradient(left,blue,#66ffff 10%,#cc00ff 20%,#CC00CC 30%, #CCCCFF 40%, #00FFFF 50%,#CCCCFF 60%,#CC00CC 70%,#CC00FF 80%,#66FFFF 90%,blue 100%);
        -webkit-text-fill-color: transparent;/* 将字体设置成透明色 */
        -webkit-background-clip: text;/* 裁剪背景图，使文字作为裁剪区域向外裁剪 */
        -webkit-background-size: 200% 100%;
        -webkit-animation: masked-animation 4s linear infinite;
        font-size: 30px;
    }

</style>
<body>
<div class="container">
    <div class="header">
        <div class="text">
            <p>短网址</p>
        </div>
    </div>
    <div class="content">
        <div>
            <?php
//            echo $options['domain']
            ?>
        </div>
        <div class="tab_wrap">
            <div class="tab_title">
                <ul class="tab_select">
                    <li class="on">
                        <a href="<?php echo $options['domain'] ?>/web_admin/###" class="shorten"><span>缩短网址</span></a>
                    </li>
                    <li>
                        <a href="<?php echo $options['domain'] ?>/web_admin/###" class="reversion"> <span>网址还原</span></a>
                    </li>
                </ul>
                <ul class="tab_other">
                    <li>
                        <a href="http://lukachen.com/api_doc.html" target="_blank"><span>API</span></a>
                    </li>
                </ul>
            </div>
            <div class="tab_body">
                <div class="url_short">
                    <div class="paste_url">
                        <label for="long_url" class="long_url_tip">请输入长网址:</label>
                        <div class="url_input">
                            <input type="text" name="long_url" id="long_url" class="to_short_content"/>
                        </div>
                        <label for="long_url">短网址:</label>
                        <div class="url_input">
                            <input type="text" class="to_short_result"/>
                        </div>
                        <div class="url_send">
                            <a href="javascript:;" class="send_button" data-type="to_short"><span>缩短网址</span></a>
                        </div>
                    </div>
                </div>
                <div class="url_revert">
                    <div class="paste_url">
                        <label for="short_url" class="url_tip">请输入短网址:</label>
                        <div class="url_input">
                            <input type="text" name="short_url" id="short_url" class="to_long_content"/>
                        </div>
                        <label for="short_url" class="url_tip">原长网址:</label>
                        <div class="url_input">
                            <input type="text" class="to_long_result"/>
                        </div>
                        <div class="url_send">
                            <a href="javascript:;" class="send_button" data-type="to_long"><span>还原网址</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="t_success_show_wrap"></div>
    </div>
    <div class="footer"></div>
</div>
<!-- 引入 jquery.js -->
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script>
    var tabs = $('ul.tab_select > li');
    var tabsbody = $('div.tab_body > div');
    $('ul.tab_select li').on('click', function(e) {
        tabs.removeClass('on');
        $(this).addClass('on');

        tabsbody.hide();
        $(tabsbody[tabs.index(this)]).show();
    });

    var url = "<?php echo $options['domain'] . '/api_gen';?>";
    $('.send_button').on('click', function(e){
        var type = $(this).data('type');
        var contentClass = '.' + type + '_content';
        var resultClass = '.' + type + '_result';
        var content = $(contentClass).val();
        var params = {
            'type': type,
            'content': encodeURIComponent(content)
        };
        $.post(url, params, function(res){
            if (res.code == '0') {
                $(resultClass).val(res.data);
            } else {
                alert(res.msg);
            }
        }, 'json')
    });
</script>
</body>
</html>