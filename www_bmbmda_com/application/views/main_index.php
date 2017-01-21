<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="content-language" content="en-us" />
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo $site['image_domain'].'/Images/favicon.ico';?>" />
	<title>Passenger SUV truck bus-bmbmda.com</title>
	<meta name="keywords" content="Tire Winter tire Tire tread  Snow  Summer All-seasons SUV Passenger Car Bus Truck" />
	<meta name="description" content="The bmbmda.com  help you quickly if you want to find out the tires, tire specifications and other information" />
	<link rel="canonical" href="http://www.bmbmda.com" />
	<link type="text/css" href="<?php echo base_url('public/home/css/common.min.css');?>" rel="stylesheet">
	<link type="text/css" href="<?php echo base_url('public/home/css/main.min.css');?>" rel="stylesheet">
</head>
<body>
<div class="header">
	<!-- <div> -->
		<ul>
			<li><a href="#" rel="nofollow">Sign in</a></li>
			<li><a href="#" rel="nofollow">Join us</a></li>
			<li><a href="#" rel="nofollow">Help</a></li>
		</ul>
	<!-- </div> -->
</div>
<div class="main" >
	<div class="homepage">
		<div class="homepage_logo">
		    <img src="<?php echo base_url('public/home/images/logo.png')?>" />
		</div>
		<form action="<?php echo site_url('search/search_detail');?>" method="post">
			<div class="homepage_search">
			    <div class="homepage_search_value">
					<input type="text" value="" name="keywords" />
				</div>
				<div class="homepage_search_submit">
					<input type="submit" value="" />
				</div>
			</div>
		</form>
		<!-- <div class="clear"></div> -->
		<div class="homepage_recommend">
		    <ul>
		        <?php foreach($recommed_model as $value):?>
				    <li>
					    <a href="<?php echo site_url('goods/goods_detail/'.$value['goodsid'].'/'.preg_replace('/[^0-9a-zA-Z]/', '-', $value['model']));?>" title="<?php echo $value['model'];?>">
						    <?php echo $value['model'];?>
					    </a>
				    </li>
				<?php endforeach;?>
		    </ul>
		</div>
		<div class="homepage_body">
			<div class="" id="slide_box">
                <div id="slideBox" class=" slideBox">
                    <div class="homepage_slide_dot hd">
                        <ul>
                            <?php foreach($category as $value):?>
	                            <li>
		                            <a href="<?php echo site_url('category/category_detail/'.$value['catid'].'/'.$value['linkurl']);?>" title="<?php echo ucfirst($value['cat_alias']);?>">
			                            <?php echo ucfirst($value['cat_alias']);?>
		                            </a>
	                            </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                    <div class="bd slider homepage_slide">
                        <div class="homepage_prev">
	                        <a class="prev" href="javascript:void(0)">
		                        <img src="<?php echo base_url('public/home/images/left_arrow.png');?>" />
	                        </a>
                        </div>
                        <div class="home_image">
	                        <ul>
	                            <?php foreach($category as $value):?>
	                            <li class="home_image_item">
	                                <div class="home_image_top">
		                                <img class="lazy"  src="<?php echo $site['image_default'];?>" data-original="<?php echo $site['image_domain'].$value['thumb'];?>" alt="bmbmda.com" title="<?php echo $value['cat_alias'];?>" />
	                                </div>
	                                <div class="home_image_body">
		                                <div class="home_image_body_l">
			                                <ol>
			                                    <?php foreach($value['brand'] as $brand_v):?>
				                                <li>
					                                <a href="<?php echo site_url('brand/brand_detail/'.$brand_v['brandid'].'/'.$brand_v['linkurl']);?>" title="<?php echo $brand_v['brand_alias'];?>">
						                                <?php echo $brand_v['brand_alias'];?>
					                                </a>
				                                </li>
				                                <?php endforeach;?>
			                                </ol>
		                                </div>
		                                <div class="home_image_body_r">
			                                <ol>
			                                    <?php foreach($value['brand'] as $brand_k2=>$brand_v2):?>
				                                <li <?php if(strcmp(strval($brand_k2),'0') == 0){echo 'class="on"';}?>>
				                                    <?php foreach($brand_v2['series'] as $series_v):?>
				                                    <div class="home_image_body_series">
					                                    <a href="<?php echo site_url('series/series_detail/'.$series_v['seriesid'].'/'.$series_v['linkurl']);?>" title="<?php echo $series_v['series_alias'];?>">
					                                    	<?php echo $series_v['series_alias'];?>
					                                    </a>
				                                    </div>
					                                <?php endforeach;?>
				                                </li>
				                                <?php endforeach;?>
			                                </ol>
		                                </div>
	                                </div>
	                                
	                            </li>
	                            <?php endforeach;?>
	                        </ul>
                        </div>
                        <!-- arrow -->
	                    <div class="homepage_next">
                            <a class="next" href="javascript:void(0)">
	                            <img src="<?php echo base_url('public/home/images/right_arrow.png');?>" />
                            </a>
                        </div>
	                    
                    </div>
                    
                </div>
            </div>
		</div>
	</div>
</div>

<div class="footer" >
<div>
Copyright © 2016 bmbmda.com 渝ICP备16011874号
</div>
</div>
<script type="text/javascript" src="<?php echo base_url('public/home/js/jQuery-2.1.4.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/home/slider/jquery.SuperSlide.2.1.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/home/js/jquery.lazyload.min.js');?>"></script>
<script type="text/javascript">
	jQuery(".slideBox").slide( { 
        mainCell:".bd ul", 
        effect:"fade",
        // autoPlay:"auto",
        trigger:"mouseover",
        easing:"swing",
        delayTime:500,
        mouseOverStop:true,
        pnLoop:false 
    });
</script>
<script type="text/javascript">
$(".home_image_body_l").on("mouseover", "li>a", function () {
        var li_index = $(this).parent().index();
        var obj = $(this);
        obj.parent().addClass("on").siblings().removeClass("on");

        obj.parent().parent().parent().parent().find('.home_image_body_r').find('li').each(function(){
        	if (parseInt($(this).index()) == parseInt(li_index)) {
                $(this).addClass("on");
            }else {
                $(this).removeClass("on");
            }
        })
    })
</script>
<script type="text/javascript">
    $(function(){
    	//异步加载图片
	    $("img.lazy").lazyload({effect: "fadeIn",threshold :10,event:"load"});
    });
</script>
</body>
</html>