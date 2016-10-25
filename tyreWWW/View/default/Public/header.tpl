<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title></title>
        <meta content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0" name="viewport"/>
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="__STATIC__/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="__STATIC__/ionicons/ionicons.min.css" />
        <link rel="stylesheet" href="__STATIC__/ionicons/font-awesome.min.css" />
        <link rel="stylesheet" href="__STATIC__/css/common.css" />
        <script src="__STATIC__/js/jQuery-2.1.4.min.js"></script>        
        <!-- <script src="__STATIC__/bootstrap/js/bootstrap.min.js"></script>         -->
    </head>
    <body>
        <div class="container-fluid header">
            <div class="container ">
                <div class="header_l">
                    Welcome to
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container search ">
                <!-- <div class="col-xs-12"> -->
                    <div class="search_l col-xs-2">
                        <a href="#">
                            <img class="img-responsive" src="__STATIC__/images/logo.png" />
                        </a>
                    </div>
                    <div class="search_r col-xs-10">
                        <div class="form-group has-feedback col-xs-12">
                            <div class="input-group col-xs-12 col-md-6 col-md-offset-6">
                            <input class="form-control" name="data[name]" value="" type="text">
                            <span class="input-group-addon search_bg">
                            <i class="fa fa-search"></i>
                            </span>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->
            </div>
        </div>
        <div class="container-fluid menu">
            <div class="container">
                <div -class="navbar-header">
                    <ul class="nav navbar-nav">
                        <foreach name="navigation" key='key' item="nav">
                            <li <if condition="strtolower(CONTROLLER_NAME) eq strtolower($nav['controller']) and strtolower(ACTION_NAME) eq strtolower($nav['action'])"> class="active"</if>>
                                <a href="{:U($nav['controller'].'/'.$nav['action'])}">{:L(strtoupper($nav['nav_name']))}</a>
                            </li>
                        </foreach>
                    </ul>
                </div>
            </div>
        </div>