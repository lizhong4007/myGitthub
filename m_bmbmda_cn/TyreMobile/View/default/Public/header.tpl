<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0" />
    <meta http-equiv="Cache-Control" content="max-age=3600" />
    <link rel="shortcut icon" type="image/x-icon" href="__STATIC__/images/favicon.ico" />
    {$seo}
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" type="text/css" href="__STATIC__/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="__STATIC__/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/common.min.css" />
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/main.min.css">
</head>
<body>
	<div class="header">
		<div class="header_title col-xs-12 row padding_0">
		    <div class="header_title_l col-xs-4 fl row ">
		    	<i class="fa fa-reorder nav_icon" ></i>
		    </div>
		    <div class="header_title_c col-xs-4">
		    	<a href="/">蹦蹦哒</a>
		    </div>
		    <div class="header_title_r col-xs-4 row ">
		    	<i class="fa fa-search btn_search"></i>
		    </div>
		</div>
		<div class="nav" >
	        <input type="hidden" value="0" id="nav_status" />
		    <ul>
		        <li class="nav_home">
		        	<a class="nav_home_l" href="/" ><i class="fa fa-home"></i>网站首页</a>
		        	<a class="nav_home_r"href="http://m.bmbmda.com" title="蹦蹦哒">English</a>
		        </li>
		        <li>
		        	<a href="{:U('Goods/goods_list',array('catid'=>13))}" title="乘用车">
			        	<i class="fa fa-angle-right"></i>
			        	乘用车
		        	</a>
		        </li>
		        <li>
		        	<a href="{:U('Goods/goods_list',array('catid'=>3))}" title="SUV">
			        	<i class="fa fa-angle-right"></i>
			        	SUV
		        	</a>
		        </li>
		        <li>
		        	<a href="#" rel="nofollow">
			        	<i class="fa fa-angle-right"></i>
			        	关于我们
		        	</a>
		        </li>
		        <li>
		        	<a href="#" rel="nofollow">
			        	<i class="fa fa-angle-right"></i>
			        	联系我们
		        	</a>
		        </li>
		    </ul>
		</div>
		<div class="search_nav col-xs-12">
		    <form action="{:U('Search/search_list')}" method="get" id="search_form">
		    <div class="search_div " >
		    	<input class="" name="q" value="" />
		    	<i class="fa fa-search" id="search_goods"></i>
		    </div>
		    </form>
		</div>
	</div>