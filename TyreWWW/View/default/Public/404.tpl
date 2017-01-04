<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0" name="viewport"/>
        <title>轮胎花纹 经销商 轮胎规格-bmbmda.com</title>
        <meta name="description" content="轮胎花纹 经销商 轮胎规格">
        <meta name="keywords" content="轮胎花纹 经销商 轮胎规格">
        <link rel="canonical" href="/404.html" />
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="__STATIC__/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="__STATIC__/ionicons/ionicons.min.css" />
        <link rel="stylesheet" href="__STATIC__/ionicons/font-awesome.min.css" />
        <link rel="stylesheet" href="__STATIC__/css/common.min.css" />
        <script src="__STATIC__/js/jQuery-2.1.4.min.js"></script> 
        <script type="text/javascript" src="__STATIC__/js/common.min.js"></script>         
    </head>
    <body>
        <div class="container-fluid">
            <div class="container search ">
                <!-- <div class="col-xs-12"> -->
                    <div class="search_l col-xs-2">
                        <a href="{$default_site}">
                            <img class="img-responsive" src="__STATIC__/images/logo.png" />
                        </a>
                    </div>
                <!-- </div> -->
            </div>
        </div>
        <style type="text/css">
        .main_body{
            min-height: 550px;
            background: #e2ebf1;
            /*background: #edf5fa;*/
        }
        .footer{
            border: none;
        }
        .s_404{
            margin-top: 30px;
        }
        .note_404 div{
            margin-top: 5px;
            font-size: 16px;
        }
        .note_404 .error_404{
            color: #0871c2;
            font-size: 2em;
            font-weight: bold;
        }
        .search_404{
            margin-top: 20px;
        }
        .search_404 input{
            width: 50% !important;
        }
        .input-group-addon{
            line-height: normal !important;
            width: auto !important;
            background: #0871c2;
            color:#fff;
            cursor: pointer;
        }
        .input-group-addon i{
            font-size: 1.5em;
        }
        </style>
        <!-- 内容 -->
        <!-- body部分 -->
        <div class="container-fluid main_body">
            <div class="container t_list ">
                <form method="post" action="{:U('search/search')}" id="search_form">
                    <div class="search_r col-xs-12 s_404">
                        <div class="fl col-xs-5 s_404_l">
                            <img src="__STATIC__/images/error404.png" />
                        </div>
                        <div class="form-group has-feedback col-xs-7 s_404_r">
                            <div class="input-group col-xs-12 note_404">
                                <div class="error_404">{:L('ADMIN_OOPS')}!</div>
                                <div>{:L('ERROR_404_NOTE')}!</div>
                                <div>{:L('ADMIN_RETURN')}
                                    <a href="{$default_site}">{:L('ADMIN_HOME')}</a>
                                </div>
                            </div>
                            <div class="input-group col-xs-12 search_404">
                            <input class="form-control fl" name="search_key" id="search_key_value" type="text">
                            <span class="input-group-addon search_bg fl" id="search_key">
                            <i class="fa fa-search fl"></i>
                            {:L('ADMIN_SEARCH')}
                            </span>
                            </div>
                        </div>
                    </div>
                </form>
           </div>
        </div>
        <!-- footer -->
        <div class="container-fluid ">
            <div class="container footer">
                <div class="footer_l col-xs-12">
                    <div class="col-xs-12 " style="margin: 0 auto">
                    <ul  style="width: 200px;">
                        <li><a href="">联系我们</a></li>
                        <li><a href="">关于我们</a></li>
                        <li><a href="">友情链接</a></li>
                    </ul>
                    </div>
                </div>
                <div class="footer_r copyright col-xs-12 ">
                    Copyright © 2016.tyre
                </div>
            </div>
        </div><!-- //footer -->
    </body>
</html>