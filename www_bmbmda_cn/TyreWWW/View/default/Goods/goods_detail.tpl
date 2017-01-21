<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/goodsdetail.min.css">

<div class="container-fluid -slide-body">
    <div class="container">
    <div class="t_nav">
    	<ul>
    		<li>
    			<a href="/">{:L("ADMIN_HOME")}</a>
    			<i>></i>
    		</li>
            <if condition="$parent_category neq ''">
        		<li>
        			<a title="{$parent_category.cat_name}" href="{:U('Goods/goods_list',array('catid'=>$parent_category['catid']))}">{$parent_category.cat_name}</a>
        			<i>></i>
        		</li>
            </if>
    		<li>
    			<a title="{$current_category.cat_name}" href="{:U('Goods/goods_list',array('catid'=>$current_category['catid']))}">{$current_category.cat_name}</a>
    			<i>></i>
    		</li>
            <if condition="$nav_series neq ''">
                <li>
                    <a title="{$nav_series['series_name']}" href="{:U('Series/series_list',array('seriesid'=>$goods['seriesid']))}">{$nav_series['series_name']}</a>
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
	    <div class="t_detail">
		    <div class="t_detail_l">
		    	<div class="t_detail_t">
			    	<div class="t_detail_image">
			    	<if condition="$goods['thumb'] eq ''">
				    	<img title="{$goods.title}" alt="{$goods.title}" class="img-responsive" src=" {$default_image}"  />
			    	 <else />
			    		<img title="{$goods.title}" alt="{$goods.title}" class="img-responsive" src=" {$site_imagedomain}{$goods.thumb}"  />
			    	</if>
			    	</div>
			    	<div class="t_detail_t_body width600 fl">
					    <div class="t_detail_title width600">
					    	<h1>
							{$goods.title}
							</h1>
					    </div>
					    <div class="t_detail_price width600">
					    	<ul>
						    	<li>
						    		<span>{:L("ADMIN_PRICE")}:</span>
						    		<em class="t_detail_price_em">
							    		<if condition="strcmp($goods['min_price'],'0.00') neq 0">
								    		<if condition="strcmp($goods['min_price'],$goods['max_price']) neq 0">
									    		{$goods.currency}{$goods.min_price}~{$goods.max_price}
								    		<else />
									    		{$goods.currency}{$goods.min_price}
								    		</if>
							    		<else />
								    		-
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
			    <div class="width900 t_detail_spec fl margintop">
				    <div class="t_spec_title width900">
				    	{:L('ADMIN_SPEC')}
				    </div>
				    <div class="t_spec_body width900">
				    	<ul class="width900">
				    	    <if condition="count($param) lt 6">
						    	<li class="width450" >
						    		<span>{:L("ADMIN_SPEC")}:</span>
						    		{$goods.model}
						    	</li>
						    	<li class="width450" >
						    		<span>{:L("ADMIN_BRAND")}:</span>
						    		{$goods.brand}
						    	</li>
						    	<li class="width450" >
						    		<span>{:L("ADMIN_SERIES")}:</span>
						    		{$nav_series['series_name']}
						    	</li>
					    	</if>
					    	<foreach name="param" key="key" item="goods_param">
					    		<li class="width450"  >
	                                <span>{$goods_param['param']}:</span>
	                                {$goods_param['value']}
	                            </li>
                            </foreach>
                            <if condition="$model_replace[0] neq ''">
	                            <li class=" model_replace width450">
		                            <div class="">
	                                <span>
	                                {:L('REPLACEABLE_SIZE')}:
	                                </span>
	                                <span class="model_replace_r">
	                                <foreach name="model_replace" key="key" item="value">
		                                <a href="">{$value.model}</a>
	                                </foreach>
	                                </span>
	                                </div>
	                            </li>
                            </if>
				    	</ul>
				    </div>
			    </div><!-- 规格结束 -->
			    <!-- 资源 -->
			    <if condition="$series_resource[0] neq '' or $model_resource[0] neq ''">
			    <div class="tyre_tread fl margintop">
				    <div class="tyre_tread_title">
					    {:L('RESOURCE')}
				    </div>
				    <div class="tyre_tread_body width900">
					    <!-- <div class="width300 fl">
					    							<div class=" tyre_tread_l_img">
					    								<img alt="{$goods.title} {:L('RESOURCE')}" title="{$goods.title} {:L('RESOURCE')}" class="img-responsive fl" src="{$site_imagedomain}{$series_resource.0.local_thumb}" />
					    							</div>
					    </div> -->
              	        <div class="width900 t_tyre_img fl">
					    	<div class="bd slider">
		                        <ul>
		                            <foreach name="series_resource" key="key" item="value">
		                                <if condition="$value['local_thumb'] neq ''"> 
									    	<li >
										    	<div>
										    	    <a href="{$site_imagedomain}{$value.local_thumb}" target="_blank" rel="nofollow">
													<img  alt="{$goods.title} {:L('RESOURCE')}" title="{$goods.title} {:L('RESOURCE')}" src="{$site_imagedomain}{$value.local_thumb}" class="img-responsive">
													</a>
												</div>
												<div class="t_tyre_content">
													{:htmlspecialchars_decode($value['content'])}
												</div>
											</li>
										</if>
							    	</foreach>
			                        <!-- arrow -->
			                        <foreach name="model_resource" key="key" item="value">
			                                <if condition="$value['resource'] neq ''">
										    	<li >
											    	<div>

											    	    <a href="{$site_imagedomain}{$value.resource}" target="_blank" rel="nofollow">
														<img  alt="{$goods.title} {:L('RESOURCE')}" title="{$goods.title} {:L('RESOURCE')}" src=" {$site_imagedomain}{$value.resource}" class="img-responsive">
														</a>
													</div>
													<div class="t_tyre_content">
														
													</div>
												</li>
											</if>
							    	</foreach>

		                        </ul>
		                        <if condition="(count($series_resource)+count($model_resource)) gt 1">
		                        <a class="prev" href="javascript:void(0)" rel="nofollow"></a>
				                <a class="next" href="javascript:void(0)" rel="nofollow"></a>
				                </if>
			                    
		                    </div>
					    </div>
				    </div>
				</div><!-- //花纹 -->
				</if>
			    
			    <!-- 手册 -->
			    <notempty name="series_manual">
			    <div class="width900 t_detail_spec fl margintop">
				    <div class="t_spec_title width900">
				    	手册
				    </div>
				    <div class="t_spec_body width900 t_series_manual">
				    	<ul class="width900">
				    	    <foreach name="series_manual" key="key" item="value">
						    	<li class="width900" >
						    		<a href="{$site_imagedomain}{$value.resource}" target="_blank">
							    		{$value.res_name}
						    		</a>
						    	</li>
					    	</foreach>
				    	</ul>
				    </div>
			    </div><!-- 手册结束 -->
			    </notempty>
			    <!-- 经销商 -->
			    <div class="width900 t_distributor fl margintop">
				    <div class="t_distributor_title width900">
					    {:L('DISTRIBUTOR')}
				    </div>
				    <div class="t_distributor_body width900">
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
							    	<a href="{$distributor[$value['companyid']]['site']['resource_url']}" target="_blank" rel="nofollow">{:L('ADMIN_CHECK')}</a>
						    	</td>
					    	</tr>
					    	</foreach>
					    </table>
				    </div>
			    </div><!-- 经销商结束 -->
			     <!-- 内容描述 -->
			    <notempty name="series_content">
			    <if condition="$series_content['language'] eq 0">
				    <div class="width900 t_detail_content fl margintop">
					    <div class="t_detail_content_title width900">
						    {:L('ADMIN_CONTENT')}{:L('ADMIN_DESCRIPTION')}
					    </div>
					    <div class="t_detail_content_body width900">
						    <ul>
							    <li>
							    	{$series_content.content}
							    </li>
						    </ul>
					    </div>
				    </div>
			    </if>
			    </notempty>
		    </div>
		    <div class="t_detail_r width300 fl">
			    <div class="t_detail_brand">
			    	<div class="t_detail_brand_title">
			    		<h1>{:L("ADMIN_BRAND")}</h1>
			    	</div>
			    	<div class="t_detail_brand_content">
			    		<ul>
				    		<foreach name="recommend_brand" key="key" item="value">
			    			<li>
			    				<i></i>
			    				<a href="{:U('Brand/brand_list',array('brandid'=>$value['brandid']))}" title="{$value.brand_name}">
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
		    <div class="t_detail_r width300 fl margintop">
			    <div class="t_detail_brand">
			    	<div class="t_detail_brand_title">
			    		<h1>你可能在找...</h1>
			    	</div>
			    	<div class="t_detail_brand_content">
			    		<ul>
				    		<foreach name="recommend_goods" key="key" item="value">
			    			<li>
			    				<i></i>
			    				<a href="{:U('Goods/detail',array('goodsid'=>$value['goodsid']))}" title="{$value.model}">
				    				{$value.model}
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
	    </div>
    </div>
</div>
<script src="__STATIC__/js/jQuery-2.1.4.min.js"></script>
<script src="__STATIC__/slider/jquery.SuperSlide.2.1.1.min.js"></script>
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
    pnLoop:false 
});
</script>
<include file="Public/footer"/>