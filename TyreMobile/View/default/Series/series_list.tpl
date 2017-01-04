<include file="Public/header"/>
	
	<div class="main">
		<div class="width100 main_nav fl">
			<ul>
				<li >
					<a href="{:U('Brand/brand_list',array('brandid'=>$brand['brandid']))}" title="{$brand.brand_name}">{$brand.brand_name}</a>
				</li>
				<li >
					<a href="{:U('Goods/goods_list',array('catid'=>$top_category['catid']))}" title="{$top_category.cat_name}">{$top_category.cat_name}</a>
				</li>
			</ul>
			<div class="clear"></div>
		</div>
		<div class="width100  seires_curr">
		    {$series.series_name}
		</div>
		<div class="sg_line"></div>
		<!-- images -->
		<div class="width100 -fl seires_img" id="slide_box">
		    <div id="slideBox" class=" slideBox">
		        <div class="slide_dot hd">
		            <ul>
		                <!-- <li>1</li> -->
		                <!-- <li>2</li>
		                <li>3</li> -->
		            </ul>
		        </div>
		        <div class="bd slider">
		            <ul>
		                <foreach name="thumb" item="value">
			                <li>
			                    <img class="img-responsive" src="{$site_imagedomain}{$value}" alt="{$series.series_name}" title="{$series.series_name}" />
			                </li>
		                </foreach>
		            </ul>
		            <!-- arrow -->
			        <if condition="count($thumb) gt '1'">
				        <a class="prev fa fa-angle-left" href="javascript:void(0)"></a>
				        <a class="next fa fa-angle-right" href="javascript:void(0)"></a>
			        </if>
		        </div>

		    </div>
		    <div class="clear"></div>
		</div>
		<!-- content -->
		<notempty name="series.content.content">
			<div class="sg_line"></div>
			<div class="series_content">
				{$series.content.content}
			</div>
		</notempty>

		<!-- goods -->
		<notempty name="goods.data">
			<div class="sg_line"></div>
			<div class="series_goods">
				<div class="series_goods_title">
					<b>型号</b>
				</div>
				<div class="series_goods_body">
				    <ul>
				        <foreach name="goods.data" item="value">
					    <li>
						    <a href="{:U('Goods/detail',array('goodsid'=>$value['goodsid']))}" title="{$value.model}">{$value.model}</a>
					    </li>
					    </foreach>
				    </ul>
					<div class="clear"></div>
				</div>
				<div class="series_goods_page">
					<ul>
					    <if condition="$goods['page']['totalPages'] gt 1">
							<notempty name="goods.page.prev">
							    <li>
								    <a href="{$goods.page.prev}" title="" class="fa fa-angle-left"></a>
							    </li>
						    <else />
							    <li>
								    <a  title="" class="fa fa-angle-left"></a>
							    </li>
						    </notempty>
						    <if condition="$goods['page']['totalPages'] neq 1">
							    <li>
								    {$goods.page.currentpage}
							    </li>
						    </if>
						    <notempty name="goods.page.next">
							    <li>
								    <a href="{$goods.page.next}"  class="fa fa-angle-right"></a>
							    </li>
						    <else />
							    <li>
								    <a   class="fa fa-angle-right"></a>
							    </li>
						    </notempty>
					    </if>
					</ul>
					<div class="clear"></div>

				</div>
			</div>
	    </notempty>

		<!-- company -->
		<notempty name="company">
			<div class="sg_line"></div>
			<div class="series_company">
				<div class="series_company_title">
					<b>经销商</b>
				</div>
				<div class="series_company_body">
					<ul>
					    <foreach name="company" item="value">
						<li>
							<div class="series_company_name">
								{$value.company_name}
							</div>
							<notempty name="value.content.telephone">
							<div class="series_company_phone">
								<i class="fa fa-phone"></i>
								{$value.content.telephone}
							</div>
							</notempty>
							<notempty name="value.content.address">
							<div class="series_company_address">
							    <i class="fa fa-map-marker"></i>
								{$value.content.address}
							</div>
							</notempty>
							<div class="series_company_contact">
								<a href="{$value.content.site}" rel="nofollow">官网</a>
							</div>
						</li>
						</foreach>
					</ul>
				</div>
			</div>
		</notempty>
	    
	    <!-- recommend -->
	    <notempty name="recommend_series">
			<div class="sg_line"></div>
			<div class="series_recommend">
				<div class="series_recommend_title">
					<b>相关系列</b>
				</div>
				<div class="series_recommend_body">
				    <ul>
				        <foreach name="recommend_series" item="value">
					    <li>
					    	<a href="{:U('Series/series_list',array('seriesid'=>$value['seriesid']))}" title="{$value.series_name}">
						    	{$value.series_name}
					    	</a>
					    </li>
					    </foreach>
				    </ul>
				    <div class="clear"></div>
				</div>
			</div>
		</notempty>
	</div>
<script type="text/javascript" src="__STATIC__/js/jQuery-2.1.4.min.js"></script>
<script type="text/javascript" src="__STATIC__/slider/jquery.SuperSlide.2.1.1.min.js"></script>
<script type="text/javascript">
jQuery(".seires_img").slide( { 
        mainCell:".bd ul", 
        effect:"fade",
        trigger:"mouseover",
        easing:"swing",
        delayTime:500,
        mouseOverStop:true,
        pnLoop:false, 
    });
</script>
<include file="Public/footer"/>