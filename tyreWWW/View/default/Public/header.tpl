<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title></title>
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0" name="viewport" />
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="__STATIC__/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="__STATIC__/ionicons/ionicons.min.css" />
        <link rel="stylesheet" href="__STATIC__/ionicons/font-awesome.min.css" />
        <link rel="stylesheet" href="__STATIC__/css/common.css" />
        <script src="__STATIC__/js/jQuery-2.1.4.min.js"></script>        
    </head>
    <body>
        <div class="container-fluid header">
            <div class="container ">
                <div class="header_l">
                    Welcome to bmbmda.com,Guest!
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container search ">
                <!-- <div class="col-xs-12"> -->
                    <div class="search_l col-xs-2">
                        <a href="{$default_site}">
                            <img class="img-responsive" src="__STATIC__/images/logo.png" />
                        </a>
                    </div>
                    <form method="post" action="{:U('Search/search',array('search_key'=>$search_key))}" id="search_form">
                    <div class="search_r col-xs-10">
                        <div class="form-group has-feedback col-xs-12">
                            <div class="input-group col-xs-12 col-md-6 col-md-offset-6">
                            <input class="form-control" name="search_key" value="" type="text" id="search_key_value">
                            <span class="input-group-addon search_bg" id="search_key">
                            <i class="fa fa-search"></i>
                            </span>
                            </div>
                            <!-- 首页推荐 -->
                            <if condition = "strtolower(CONTROLLER_NAME) eq  'homepage' and strtolower(ACTION_NAME) eq 'index' ">
                            <div class="input-group col-xs-12 col-md-6 col-md-offset-6 recommend_model">
                                <ul>
                                    <foreach name="recommed_goods" key='key' item="value">
                                    <li>
                                        <a href="{:U('goods/detail',array('goodsid'=>$value['goodsid']))}">{$value['model']}</a>
                                    </li>
                                    </foreach>
                                </ul>
                            </div>
                            </if>
                            <!-- //首页推荐 -->
                        </div>
                    </div>
                    </form>

                <!-- </div> -->
            </div>
        </div>
        <div class="container-fluid menu">
            <div class="container">
                <div -class="navbar-header">
                    <ul class="nav navbar-nav">
                        <foreach name="navigation" key='key' item="nav">
                            <li >
                                <if condition="strtolower($nav['nav_name']) eq 'suv'">
                                <a  href="{:U($nav['controller'].'/'.$nav['action'],array('catid'=>3))}" <if condition="strtolower(CONTROLLER_NAME) eq strtolower($nav['controller']) and strtolower(ACTION_NAME) eq strtolower($nav['action']) and $catid eq 3"> class="active"</if>>
                                    {:L(strtoupper($nav['nav_name']))}
                                </a>
                                <else />
                                    <if condition="strtolower($nav['nav_name']) eq strtolower('PASSENGER_CAR')">
                                    <a href="{:U($nav['controller'].'/'.$nav['action'],array('catid'=>13))}" <if condition="strtolower(CONTROLLER_NAME) eq strtolower($nav['controller']) and strtolower(ACTION_NAME) eq strtolower($nav['action']) and $catid eq 13"> class="active"</if>>
                                        {:L(strtoupper($nav['nav_name']))}
                                    </a>
                                    <else />
                                    <a href="{:U($nav['controller'].'/'.$nav['action'])}" <if condition="strtolower(CONTROLLER_NAME) eq strtolower($nav['controller']) and strtolower(ACTION_NAME) eq strtolower($nav['action'])"> class="active"</if>>
                                        {:L(strtoupper($nav['nav_name']))}
                                    </a>
                                    </if>
                                </if>

                            </li>
                        </foreach>
                    </ul>
                </div>
            </div>
        </div>
