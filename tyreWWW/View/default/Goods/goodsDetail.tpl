<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/goodsdetail.css">
<script src="__STATIC__/slider/jquery.SuperSlide.2.1.1.js"></script>
<div class="container-fluid -slide-body">
    <div class="container">
    <div class="t_nav">
    	<ul>
    		<li>
    			<a href="{:U('Home/index')}">{:L("ADMIN_HOME")}</a>
    			<i>></i>
    		</li>
            <if condition="$parent_category neq ''">
        		<li>
        			<a href="{:U('Goods/goods_list',array('catid'=>$parent_category['catid']))}">{$parent_category.cat_name}</a>
        			<i>></i>
        		</li>
            </if>
    		<li>
    			<a href="{:U('Goods/goods_list',array('catid'=>$current_category['catid']))}">{$current_category.cat_name}</a>
    			<i>></i>
    		</li>
            <if condition="$nav_series neq ''">
                <li>
                    <a href="{:U('Series/series_list',array('seriesid'=>$goods['seriesid']))}">{$nav_series['series_name']}</a>
                    <i>></i>
                </li>
            </if>
            <if condition="$nav_model neq ''">
        		<li>{$nav_model['model']}</li>
            </if>
    	</ul>
    </div>
    </div>
</div>
<!-- 标题 -->
<div class="container-fluid">
    <div class="container">
	    <div class="col-xs-12 t_detail">
		    <div class="t_detail_l col-xs-9">
		    	<div class="col-xs-12 t_detail_t">
			    	<div class="t_detail_image col-xs-4">
			    		<img class="img-responsive" src="<if condition="$goods['thumb'] eq ''"> {$default_image} <else />{$site_imagedomain}{$goods.thumb}</if>" />
			    	</div>
			    	<div class="col-xs-8">
					    <div class="t_detail_title col-xs-12 row">
					    	<h1>
							{$goods.title}
							</h1>
					    </div>
					    <div class="t_detail_price col-xs-12 row">
					    	<ul>
						    	<li>
						    		<span>{:L("ADMIN_PRICE")}:</span>
						    		<em class="t_detail_price_em">
							    		<if condition="$goods['min_price'] neq '0.00'">
								    		<if condition="$goods['min_price'] neq $goods['max_price']">
									    		￥{$goods.min_price}~{$goods.max_price}
								    		<else />
									    		￥{$goods.min_price}
								    		</if>
							    		<else />
								    		GX
							    		</if>
						    		</em>
						    	</li>
						    	<li>
						    		<span>{:L("ADMIN_BRAND")}:</span>
						    		{$goods.brand}
						    	</li>
						    	<li>
						    		<span>{:L("ADMIN_CAT")}:</span>
						    		{$current_category.cat_name}
						    	</li>
						    	<li>
						    		<span>{:L("ADMIN_MODEL")}:</span>
						    		{$nav_model['model']}
						    	</li>
					    	</ul>
					    </div>
				    </div>
			    </div><!-- 详情结束 -->
			    <!-- 花纹 -->
			    <if condition="$series_resource[0] neq ''">
			    <div class="col-xs-12 tyre_tread ">
				    <div class="tyre_tread_title col-xs-12 ">
					    {:L('TYRE_TREAD')}
				    </div>
				    <div class="tyre_tread_body col-xs-12 ">
					    <div class="col-xs-6 ">
							<div class="col-xs-12 tyre_tread_l_img">
								<img class="img-responsive" src="{$site_imagedomain}{$series_resource.0.local_thumb}" />
							</div>
					    </div>
              	        <div class="col-xs-6 t_tyre_img">
					    	<div class="bd slider">
		                        <ul>
		                            <foreach name="series_resource" key="key" item="value">
			                            <if condition="$key neq 0">
									    	<li >
										    	<div>
													<img src="<if condition="$value['local_thumb'] eq ''"> {$default_image} <else />{$site_imagedomain}{$value.local_thumb}</if>" class="img-responsive">
												</div>
												<div class="t_tyre_content">
													{:htmlspecialchars_decode($value['content'])}
												</div>
											</li>
										</if>
							    	</foreach>
			                        <!-- arrow -->

		                        </ul>
		                        <a class="prev" href="javascript:void(0)"></a>
				                    <a class="next" href="javascript:void(0)"></a>
			                    
		                    </div>
					    </div>
				    </div>
				</div><!-- //花纹 -->
				</if>
			    <div class="col-xs-12 t_detail_spec">
				    <div class="t_spec_title col-xs-12">
				    	{:L('ADMIN_SPEC')}
				    </div>
				    <div class="t_spec_body col-xs-12">
				    	<ul class="col-xs-12 row">
					    	<li class="col-xs-6 row">
					    		<span>{:L("ADMIN_SPEC")}:</span>
					    		{$goods.model}
					    	</li>
					    	<li class="col-xs-6 row">
					    		<span>{:L("ADMIN_BRAND")}:</span>
					    		{$goods.brand}
					    	</li>
					    	<li class="col-xs-6 row">
					    		<span>{:L("ADMIN_SERIES")}:</span>
					    		{$nav_series['series_name']}
					    	</li>
					    	<foreach name="param" key="key" item="goods_param">
					    		<li class="col-xs-6 row">
	                                <span>{$key}:</span>
	                                {$goods_param}
	                            </li>
                            </foreach>
                            <if condition="$model_replace[0] neq ''">
	                            <li class="col-xs-6 row model_replace">
		                            <div class="col-xs-12 row">
	                                <span>
	                                {:L('REPLACEABLE_SIZE')}:
	                                </span>
	                                <span class="model_replace_r">
	                                <foreach name="model_replace" key="key" item="value">
		                                <a href="">{$value.model}</a><br />
	                                </foreach>
	                                </span>
	                                </div>
	                            </li>
                            </if>
				    	</ul>
				    </div>
			    </div><!-- 规格结束 -->
			    <!-- 经销商 -->
			    <div class="col-xs-12 t_distributor">
				    <div class="t_distributor_title col-xs-12">
					    {:L('DISTRIBUTOR')}
				    </div>
				    <div class="t_distributor_body col-xs-12">
					    <table width="100%">
					    	<tr>
						    	<th>{:L('DISTRIBUTOR')}</th>
						    	<th>{:L('ADMIN_MODEL')}</th>
						    	<th>{:L('ADMIN_PRICE')}</th>
						    	<th>{:L('OFFICIAL_WEBSITE')}</th>
					    	</tr>
					    	<foreach name="company" key="key" item="value">
					    	<tr>
						    	<td>
							    	{$value.company_name}
						    	</td>
						    	<td>
							    	{$distributor[$value['companyid']]['model']}
						    	</td>
						    	<td>
							    	<if condition="$goods['min_price'] neq '0.00'">
							    		<em>￥{$goods.min_price}</em>
						    		<else />
							    		-
						    		</if>
						    	</td>
						    	<td>
							    	<a href="{$distributor[$value['companyid']]['site']['resource_url']}" target="_blank">{:L('ADMIN_CHECK')}</a>
						    	</td>
					    	</tr>
					    	</foreach>
					    </table>
				    </div>
			    </div><!-- 经销商结束 -->
			     <!-- 内容描述 -->
			    <div class="col-xs-12 t_detail_content">
				    <div class="t_detail_content_title col-xs-12">
					    {:L('ADMIN_CONTENT')}{:L('ADMIN_DESCRIPTION')}
				    </div>
				    <div class="t_detail_content_body col-xs-12">
					    <ul>
						    <li>
						    	{$series_content['content']}
						    </li>
					    </ul>
				    </div>
			    </div><!-- 经销商结束 -->
		    </div>
		    <div class="t_detail_r col-xs-3">
			    <div class="t_detail_brand">
			    	<div class="t_detail_brand_title">
			    		<h1>{:L("ADMIN_BRAND")}</h1>
			    	</div>
			    	<div class="t_detail_brand_content">
			    		<ul>
				    		<foreach name="recommend_brand" key="key" item="value">
			    			<li>
			    				<i></i>
			    				<a href="{:U('Brand/brand_list',array('brandid'=>$value['brandid']))}">
				    				{$value.brand_name}
			    				</a>
			    			</li>
			    			</foreach>
			    		</ul>
			    	</div>
			    	<input type="hidden" id="more_open" value="0" />
			    	<input type="hidden" id="more_value" value="{:L('ADMIN_MORE')}" />
			    	<input type="hidden" id="less_value" value="{:L('ADMIN_LESS')}" />
			    	<div class="t_brand_more">{:L('ADMIN_MORE')}</div>
			    </div>
		    </div>
		   <!--  <div class="t_detail_r col-xs-3">
			    <div class="t_detail_brand">
			    	<div class="t_detail_brand_title">
			    		<h1>品牌</h1>
			    	</div>
			    	<div class="t_detail_brand_content">
			    		<ul>
			    			<li>
			    				<i></i><a href="">韩泰</a>
			    			</li>
			    			<li>
			    				<i></i><a href="">固特异</a>
			    			</li>
			    			<li>
			    				<i></i><a href="">韩泰</a>
			    			</li>
			    			<li>
			    				<i></i><a href="">固特异</a>
			    			</li>
			    			<li>
			    				<i></i><a href="">韩泰</a>
			    			</li>
			    			<li>
			    				<i></i><a href="">固特异</a>
			    			</li>
			    		</ul>
			    	</div>
			    	<input type="hidden" id="more_open" value="0" />
			    	<input type="hidden" id="more_value" value="更多" />
			    	<input type="hidden" id="less_value" value="收起" />
			    	<div class="t_brand_more">更多</div>
			    </div>
		    </div> -->
	    </div>
    </div>
</div>
<script type="text/javascript">
	$(".t_brand_more").on("click",function(){
		var obj = $(this);
		var less_value = $("#less_value").val();
		var more_value = $("#more_value").val();
		var more_open = $("#more_open").val();
		if(more_open == 0)
		{
			$("#more_open").val("1");
			obj.parent().css({"height":"auto"});
			obj.html(less_value);
		}else{
			$("#more_open").val("0");
			obj.parent().css({"height":"205px"});
			obj.html(more_value);
		}
	})
</script>
<script id="jsID" type="text/javascript">
jQuery(".t_tyre_img").slide( { 
    mainCell:".bd ul", 
    effect:"fade",
    // autoPlay:"auto",
    trigger:"mouseover",
    easing:"swing",
    delayTime:500,
    mouseOverStop:true,
    pnLoop:true 
});
</script>
<include file="Public/footer"/>