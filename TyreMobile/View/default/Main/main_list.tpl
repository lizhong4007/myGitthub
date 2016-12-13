<include file="Public/header"/>
	<!-- goods list -->
	<div class="home_main">
		<!-- goods -->
		<div class="home_series">
			<div class="home_series_body">
			    <ul>
				    <foreach name="data" item="category">
				    
				    <li class="home_series_category">
				        <div class="home_category_name">
					        {$category.cat_name}
				        </div>
				        <div class="home_series_list">
						    <ul>
						        <foreach name="category.series" item="value">
							    <li class="home_series_data">
								    <a href="{:U('series/series_list',array('seriesid'=>$value['series']['seriesid']))}"  title="{$value.series.series_name}">
								        <div class="home_series_img">
								        <img title="{$value.series.series_name}" alt="{$value.series.series_name}"  class=" lazy" src="{$default_image}" data-original="{$site_imagedomain}{$value.series.thumb}" />
									    </div>
									    <div class="home_series_title">
										    {$value.series.series_name}
									    </div> 
									    <div class="home_series_more">
										    更多<i class="fa fa-angle-double-right"></i>
									    </div> 
								    </a>
									    <div class="home_brand_name">
										    <a href="{:U('Brand/brand_list',array('brandid'=>$value['brand']['brandid']))}" title="{$value.brand.brand_name}">
										    {$value.brand.brand_name}</a>
									    </div>
							    </li>
							    </foreach>

							    <div class="clear"></div>
						    </ul>
				        </div>
				    </li>

				    </foreach>
			    </ul>
			</div>
			
		</div>
	</div>
<script src="__STATIC__/js/jQuery-2.1.4.min.js"></script>
<script src="__STATIC__/js/jquery.lazyload.min.js"></script>
<script type="text/javascript">
    $(function() {
         //异步加载图片
        $("img.lazy").lazyload({effect: "fadeIn",failurelimit:10});
    })
</script>
<include file="Public/footer"/>