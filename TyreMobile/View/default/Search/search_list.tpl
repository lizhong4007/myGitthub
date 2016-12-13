<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0" />
    <title>轮胎搜索器-蹦蹦哒</title>
    <meta name="description" content="" />
    <meta name="keywords" content="蹦蹦哒 轮胎 规格 型号 轮胎搜索器 花纹 经销商" />
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" type="text/css" href="__STATIC__/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="__STATIC__/bootstrap/css/bootstrap.min.css" />
     <link rel="stylesheet" href="__STATIC__/css/common.min.css" />
    <link rel="stylesheet" href="__STATIC__/css/media.min.css" />
	<link rel="stylesheet" type="text/css" href="__STATIC__/css/main.min.css">
    <link rel="canonical" href="http://www.bmbmda.com{:U('Search/search_list')}/{$currentpage}" />
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
		    
		</div>
		<div class="nav" >
	        <input type="hidden" value="0" id="nav_status" />
		    <ul>
		        <li>
		        	<a href="/" ><i class="fa fa-home"></i>网站首页</a>
		        </li>
		        <li>
		        	<a href="{:U('Goods/goods_list',array('catid'=>13))}" rel="nofollow">
			        	<i class="fa fa-angle-right"></i>
			        	乘用车
		        	</a>
		        </li>
		        <li>
		        	<a href="{:U('Goods/goods_list',array('catid'=>3))}" rel="nofollow">
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
	</div>
	<div class="search_goods_nav col-xs-12">
		    <form action="{:U('Search/search_list')}" method="get" id="search_form">
			    <div class="search_goods_div " id="search_goods">
			    	<input class="" name="q" value="{$search_key}" />
			    	<i class="fa fa-search"></i>
			    </div>
		    </form>
		    <div class="clear">
			</div>
		</div>
		<div class="clear">
		</div>
	<div class="search_main">
		<!-- goods -->
		<empty name="goods">
			<div class="search_goods">
				<div class="search_goods_title_error">
					<b>抱歉！没有您想要的商品...</b>
				</div>
			</div>
		<else />
		<div class="search_goods">
			<div class="search_goods_title">
				<b>匹配商品(<i>{$totalrows}件</i>)</b>
			</div>
			<div class="search_goods_body">
			    <ul>
				    <foreach name="goods" item="value">
					    <li >
					        <div class="search_goods_title">
						        <a href="{:U('Goods/detail',array('goodsid'=>$value['goodsid']))}" title="{$value.title}">
							        <i class="fa fa-circle-thin" aria-hidden="true"></i>
							        {$value.series.series_alias}<br />
							        <span>{$value.title}</span>
						        </a>
					        </div>
					    </li>
				    </foreach>
			    </ul>
			</div>
			<div class="search_goods_page">
				<ul>
					<notempty name="page">
					    <li>
						    <a href="{$page.prev}" class="fa fa-angle-left"></a>
					    </li>
					<else />
					    <li>
						    <a  class="fa fa-angle-left"></a>
					    </li>
				    </notempty>
				    <if condition="$page['totalPages'] neq 1">
					    <li>
						    {$page.currentpage}
					    </li>
				    </if>
				    <notempty name="page.next">
					    <li>
						    <a href="{$page.next}"  class="fa fa-angle-right"></a>
					    </li>
					<else />
					    <li>
						    <a  class="fa fa-angle-right"></a>
					    </li>
				    </notempty>
				</ul>
				<div class="clear"></div>
			</div>
		</div>
		</empty>
	</div>	
<script src="__STATIC__/js/jQuery-2.1.4.min.js"></script>
<include file="Public/footer"/>