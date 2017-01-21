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
			
		</ul>
	</div>
</div>
<div class="main" >
	<div class="search_detail">
		<div class="search_detail_title">
		    <form action="<?php echo site_url('search/search_detail');?>" method="post">
		        <div class="search_keywords" >
				    <input type="text" value="<?php if(!empty($keywords)){echo $keywords;} ?>" name="keywords" placeholder="search......" />
			    </div>
			    <div  class="search_submit" >
			    	<input type="submit" value="" />
		    	</div>
		    </form>

		</div>
		<div class="search_body">
			<div class="search_body_r">
			    <div class="search_body_t">
			    	<ul>
				    	<?php echo $page;?>
			    	</ul>
			    </div>
			    <div class="search_body_t_b">
				    <ul>
				        <?php if(!empty($goods)):?>
					        <?php foreach ($goods as $key => $value): ?>
					    		<li>
					    		    <div class="search_body_t_b_image">
					    		        <a href="<?php echo site_url('goods/goods_detail/'.$value['goodsid'].'/'.$value['linkurl']);?>" title="<?php echo $value['en_title'];?>" > 
							    		    <img class="lazy"  src="<?php echo $site['image_default'];?>" data-original="<?php echo $site['image_domain'].$value['thumb'];?>" alt="<?php echo $value['en_title'];?>"  title="<?php echo $value['en_title'];?>" />
						    		    </a>
					    		    </div>
					    		    <div class="search_body_t_b_title">
						    		    <a href="<?php echo site_url('goods/goods_detail/'.$value['goodsid'].'/'.$value['linkurl']);?>" title="<?php echo $value['en_title'];?>" >
							    		    <?php echo $value['en_title'];?>
						    		    </a>
					    		    </div>
					    			
					    		</li>
				    		<?php endforeach ?>
				    	<?php else: ?>
				    		   <li>
					    		   <h4>The goods you want to find can not find......</h4>
					    		   <h4>Try another again!</h4>
				    		   </li>
				    	<?php endif ?>
			    		
			    	</ul>

			    	
			    </div>

			    <div class="search_body_t">
			    	<ul>
				    	<?php echo $page;?>
			    	</ul>
			    </div>
			</div>
		</div>
	</div>
</div>
