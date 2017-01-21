<include file="Public/header"/>	
	
	<div class="main">
		<div class="width100 main_nav fl">
			<ul>
				<li >
					<a href="{:U('Brand/brand_list',array('brandid'=>$goods['brandid']))}" title="{$goods.brand}">{$goods.brand}</a>
				</li>
				<li >
					<a href="{:U('Goods/goods_list',array('catid'=>$top_category['catid']))}" title="{$top_category.cat_name}">{$top_category.cat_name}</a>
				</li>
				<if condition="strcmp($goods['min_price'],'0.00') neq 0">
					<div class=" goods_price">
					    {$goods.currency}{$goods.min_price}
					</div>
				</if>
			</ul>
			
			<div class="clear"></div>
		</div>
		<div class="width100 seires_curr">
		    {$series.series_name}
		</div>
		
		<div class="sg_line"></div>
		<!-- images -->
		<div class="width100 seires_img" id="slide_box">
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
			                    <img title="{$series.series_name}" alt="{$series.series_name}"  class=" lazy" src="{$default_image}" data-original="{$site_imagedomain}{$value}" />
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
		<notempty name="goods.content.content">
			<if condition="$goods['content']['language'] eq 0">
				<div class="sg_line"></div>
				<div class="series_content">
					{$goods.content.content}
				</div>
			</if>
		</notempty>
		<!-- goods spec -->
		<div class="sg_line"></div>
		<div class="goods_detail_spec">
		    <div class="goods_detail_spec_title">
		    	<b>规格</b>
		    </div>
		    <div class="goods_detail_spec_body">
			    <ul>
			        <if condition="count($param) lt 5">
				        <li>
						    <span>型号: </span>{$goods.model} 
					    </li>
					    <li>
						    <span>花纹: </span>{$series.series_name} 
					    </li>
					    <li>
						    <span>品牌: </span>{$goods.brand} 
					    </li>
				    </if>
			        <foreach name="param" item="value">
				    <li>
				    	<span>{$value.param}: </span>{$value.value}  
				    </li>
				    </foreach>
				    <!-- <notempty name="model_replace">
				    <li>
				    	<span>可替换型号: </span>
				    	<foreach name="model_replace" item="value">
				    					    	<a href="{:U('Goods/detail',array('goodsid'=>$value['modelid']))}" title="{$value.model}">{$value.model}</a> 
				    	</foreach> 
				    </li>
				    </notempty> -->
			    </ul>
			    <div class="clear"></div>
		    </div>
		</div>
		
		<!-- resource -->
		<if condition="$series_resource[0] neq '' or $model_resource[0] neq ''">
			<div class="sg_line"></div>
			<div class="width100 model_resource" id="model_resource_box">
			    <div class="model_resource_title">
			    	<b>资源</b>
			    </div>
			    <div id="modelresourceBox" class=" modelresourceBox slideBox">
			        <div class="slide_dot hd">
			            <ul>
			                <!-- <li>1</li> -->
			                <!-- <li>2</li>
			                <li>3</li> -->
			            </ul>
			        </div>
			        <div class="bd slider">
			            <ul>
			                <foreach name="series_resource" item="value">
				                <li>
					                <img  class="img-responsive" src="{$site_imagedomain}{$value.local_thumb}" alt="{$value.title}" title="{$value.title}" />
				                    <a href="{$site_imagedomain}{$value.resource}" class="src_large fa fa-search " rel="nofollow" title="放大" target="_blank"></a>
				                    <notempty name="value.content">
					                    <div class="silde_content">
						                    {$value.content}
					                    </div>
				                    </notempty>
				                </li>
			                </foreach>
			                <foreach name="model_resource" item="value">
			                    <if condition="$value['resource'] neq ''">
					                <li>
						                <img  class="img-responsive" src="{$site_imagedomain}{$value.resource}" alt="{$value.title}" title="{$value.title}" />
						                <a href="{$site_imagedomain}{$value.resource}" class="src_large fa fa-search " target="_blank" rel="nofollow" title="放大"></a>

					                </li>
					            </if>
			                </foreach>
			            </ul>

			            <if condition="(count($series_resource)+count($model_resource)) gt 1">
					        <!-- arrow -->
					        <a class="prev fa fa-angle-left" href="javascript:void(0)"></a>
					        <a class="next fa fa-angle-right" href="javascript:void(0)"></a>
				        </if>
				        
			        </div>
			        
			    </div>
			    <div class="clear"></div>
			</div>
		</if>

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
								{$value.content.distributor_name}
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
	    <notempty name="recommend_model">
			<div class="sg_line"></div>
			<div class="series_recommend">
				<div class="series_recommend_title">
					<b>相关型号</b>
				</div>
				<div class="series_recommend_body">
				    <ul>
				        <foreach name="recommend_model" item="value">
					    <li>
					    	<a href="{:U('Goods/detail',array('goodsid'=>$value['goodsid']))}">
						    	{$value.model}
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
<script type="text/javascript" src="__STATIC__/js/jquery.lazyload.min.js"></script>
<script type="text/javascript">
jQuery(".modelresourceBox").slide( { 
        mainCell:".bd ul", 
        effect:"fade",
        trigger:"mouseover",
        easing:"swing",
        delayTime:500,
        mouseOverStop:true,
        pnLoop:false, 
    });
jQuery(".seires_img").slide( { 
        mainCell:".bd ul", 
        effect:"fade",
        trigger:"mouseover",
        easing:"swing",
        delayTime:500,
        mouseOverStop:true,
        pnLoop:false, 
    });
 $(function() {
         //异步加载图片
        $("img.lazy").lazyload({effect: "fadeIn",failurelimit:10});
    })
</script>
<include file="Public/footer"/>