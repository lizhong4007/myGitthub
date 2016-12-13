<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0" name="viewport" />
        <meta http-equiv="Cache-Control" content="max-age=3600" />
        <link rel="shortcut icon" type="image/x-icon" href="__STATIC__/images/favicon.ico" />
        {$seo}
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" type="text/css" href="__STATIC__/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="__STATIC__/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="__STATIC__/css/common.min.css" />        
    </head>
    <body>
        <div class="container-fluid header ">
            <div class="container ">
                <div class="header_c">
                    <div class="header_l">
                        Welcome to bmbmda.com,Guest!
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container ">
                <div class="search ">
                    <div class="search_l">
                        <a href="{$default_site}" title="bmbmda">
                            <img title="bmbmda" alt="bmbmda" class="img-responsive" src="__STATIC__/images/logo.gif" />
                        </a>
                    </div>
                    <form method="post" action="{:U('Search/search',array('search_key'=>$search_key))}" id="search_form">
                    <div class="search_r">
                        <div class="form-group has-feedback">
                            <div class="input-group">
                            <input class="form-control" name="search_key" value="" type="text" id="search_key_value">
                            <span class="input-group-addon search_bg" id="search_key">
                            <i class="fa fa-search"></i>
                            </span>
                            </div>
                            <!-- 首页推荐 -->
                            <if condition = "strtolower(CONTROLLER_NAME) eq  'homepage' and strtolower(ACTION_NAME) eq 'index' ">
                            <div class="input-group recommend_model">
                                <ul>
                                    <foreach name="recommed_goods" key='key' item="value">
                                    <li>
                                        <a href="{:U('goods/detail',array('goodsid'=>$value['goodsid']))}" title="{$value.model}">{$value.model}</a>
                                    </li>
                                    </foreach>
                                </ul>
                            </div>
                            </if>
                            <!-- //首页推荐 -->
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container-fluid menu">
            <div class="container">
                <div class="menu-header">
                    <ul >
                        <foreach name="navigation" key='key' item="nav">
                            <li >
                                <if condition="strtolower($nav['nav_name']) eq 'suv'">
                                <a title="{:L(strtoupper($nav['nav_name']))}" href="{:U($nav['controller'].'/'.$nav['action'],array('catid'=>3))}" <if condition="strtolower(CONTROLLER_NAME) eq strtolower($nav['controller']) and strtolower(ACTION_NAME) eq strtolower($nav['action']) and $catid eq 3" > class="active"</if>>
                                    {:L(strtoupper($nav['nav_name']))}
                                </a>
                                <else />
                                    <if condition="strtolower($nav['nav_name']) eq strtolower('PASSENGER_CAR')">
                                    <a title="{:L(strtoupper($nav['nav_name']))}" href="{:U($nav['controller'].'/'.$nav['action'],array('catid'=>13))}" <if condition="strtolower(CONTROLLER_NAME) eq strtolower($nav['controller']) and strtolower(ACTION_NAME) eq strtolower($nav['action']) and $catid eq 13"> class="active"</if>>
                                        {:L(strtoupper($nav['nav_name']))}
                                    </a>
                                    <else />
                                    <if condition = "$nav['navid'] eq 1 ">
                                    <a title="{:L(strtoupper($nav['nav_name']))}" href="/" <if condition="strtolower(CONTROLLER_NAME) eq strtolower('homepage')"> class="active"</if>>
                                        {:L(strtoupper($nav['nav_name']))}
                                    </a>
                                    <else />
                                    <a title="{:L(strtoupper($nav['nav_name']))}" href="{:U($nav['controller'].'/'.$nav['action'])}" <if condition="strtolower(CONTROLLER_NAME) eq strtolower($nav['controller']) and strtolower(ACTION_NAME) eq strtolower($nav['action'])"> class="active"</if>>
                                        {:L(strtoupper($nav['nav_name']))}
                                    </a>


                                    </if>
                                    
                                    </if>
                                </if>

                            </li>
                        </foreach>
                    </ul>
                </div>
            </div>
        </div>
