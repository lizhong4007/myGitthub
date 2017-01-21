<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="content-language" content="en-us" />
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $site['image_domain'].'/Images/favicon.ico';?>" />
	<?php echo $seo;?>
	<link type="text/css" href="<?php echo base_url('public/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">
	<link type="text/css" href="<?php echo base_url('public/home/css/common.min.css');?>" rel="stylesheet">
	<link type="text/css" href="<?php echo base_url('public/home/css/goods_detail.min.css');?>" rel="stylesheet">
</head>
<style type="text/css">
	body{
		background: #61B6F6;
	}
</style>
<body>
<div class="header">
	<!-- <div> -->
		<ul>
			<li><a href="" rel="nofollow">Sign in</a></li>
			<li><a href="" rel="nofollow">Join us</a></li>
			<li><a href="" rel="nofollow">Help</a></li>
			<li><a href="http://www.bmbmda.cn" >Chinese</a></li>
		</ul>
	<!-- </div> -->
</div>
<div class="all_nav">
	<div class="nav_tab">
		<ul>
		    <li class="nav_tab_li_0">
				<img src="<?php echo base_url('public/home/images/head_logo.gif')?>" />
			</li>
			<li class="nav_tab_li">
			    <a href="/" title="bmbmda.com">Home</a>
			</li>
			<li class="nav_tab_li ">
			    <a href="<?php echo site_url('category/category_detail/13/passenger.html');?>" title="Passenger">Passenger</a>
			</li>
			<li class="nav_tab_li">
			    <a href="<?php echo site_url('category/category_detail/3/suv.html');?>" title="SUV">SUV</a>
			</li>
			<li class="nav_tab_li">
			    <a href="<?php echo site_url('category/category_detail/53/truck-bus.html');?>" title="Truck">Truck/Bus</a>
			</li>
			<li class="header_search">
			    <a href="<?php echo site_url('search/search_detail');?>"></a>
			</li>
		</ul>
	</div>
</div>