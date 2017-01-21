<include file="Public/header"/>
	<div class="main">
		<div class="width100  brand_nav">
		    <div class="brand_logo">
			    <img class="img-responsive" src="{$site_imagedomain}{$brand.thumb}" alt="{$brand.brand_name}" title="{$brand.brand_name}" />
		    </div>
		    <div class="brand_name">
			    {$brand.brand_name}
		    </div>
		</div>
		<!-- goods -->
		<div class="sg_line"></div>
		<div class="brand_series">
			<div class="brand_series_title">
				<b>系列</b>
			</div>
			<div class="brand_series_body">
			    <div>
				    <ul>
				        <foreach name="series" item="category">
						    <li class="brand_category">
						        <div class="brand_category_name" data="0">
							        <i class="fa fa-angle-right"></i>
							        {$category.cat_name}
						        </div>
						        <div class="brand_series_content">
							        <ul>
								        <foreach name="category.series" item="series">
									        <li>
										        <a href="{:U('Series/series_list',array('seriesid'=>$series['seriesid']))}" title="{$series.series_name}">{$series.series_name}</a>
									        </li>
								        </foreach>
							        </ul>
							        <div class="clear"></div>
							        <if condition="$category['status'] eq 1">
								        <div class="brand_series_more">
									        <a href="{:U('Goods/goods_list',array('brandid'=>$brand['brandid'],'catid'=>$category['catid']))}" title="{$category.cat_name}" >
										        more
										        <i class="fa fa-angle-double-right"></i>
									        </a>
								        </div>
							        </if>
						        </div>
						    </li>
					    </foreach>
				    </ul>
			    </div>
			</div>
		</div>

	    <!-- recommend -->
		<div class="sg_line"></div>
		<div class="brand_recommend">
			<div class="brand_recommend_title">
				<b>其他品牌</b>
			</div>
			<div class="brand_recommend_body">
			    <ul>
			    <foreach name="recommend_brand" item="value">
				    <li>
				    	<a href="{:U('Brand/brand_list',array('brandid'=>$value['brandid']))}" title="{$value.brand_name}">
					    	{$value.brand_name}
				    	</a>
				    </li>
				</foreach>
			    </ul>
			    <div class="clear"></div>
			</div>
		</div>
	</div>
<script type="text/javascript" src="__STATIC__/js/jQuery-2.1.4.min.js"></script>
<script type="text/javascript" src="__STATIC__/js/brand.min.js"></script>
<include file="Public/footer"/>