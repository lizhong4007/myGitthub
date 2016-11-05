<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/searchlist.css">
<!-- 页面标题 -->
<input type="hidden" value="轮胎搜索器-bmbmda.com" id="site_title" />
<input type="hidden" value="" id="site_keywords" />
<input type="hidden" value="" id="site_description" />
<!-- //页面标题 -->
<!-- <div class="container-fluid -slide-body">
    <div class="container">
    <div class="t_nav">
    	<ul>
    		<li>
    			<a href="{:U('HomePage/index')}">{:L("ADMIN_HOME")}</a>
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
            <li>
		       <input type="hidden" value="{$nav_series.seriesid}" id="seriesid" />
                {$nav_series['series_name']}
            </li>
    	</ul>
    </div>
    </div>
</div> -->
<!-- nav -->
<div class="container-fluid">
    <div class="container all_selector">
	    <!-- <div class="t_selector col-xs-12">
		    <div class="t_selector_l col-xs-1">
			    {:L('ADMIN_BRAND')}:
		    </div>
		    <div class="t_selector_r col-xs-11">
			    <ul class=" col-xs-12 row">
				    <li class="col-xs-2 row t_selector_brand">
				    	<div class="t_selector_img">
					    	<img  src="<if condition="$brand['thumb'] eq ''">{$default_image}<else />{$site_imagedomain}{$brand.thumb}</if>" />
					    </div>
					    <div class="t_selector_title">
					    	<a href="{:U('Brand/brand_list',array('brandid'=>$brand['brandid']))}">
						    	{$brand.brand_name}
					    	</a>
					    </div>
				    </li>
			    </ul>
		    </div>
	    </div> -->
	    <!-- 筛选条件 扁平率 -->
	    <!-- <input type="hidden" value="{:U('Series/get_filter_goods')}" id="filter_url" />
	    <foreach name="goods_filter" key="key" item="filter">
	     <div class="t_filter col-xs-12">
		    <div class="t_filter_l col-xs-1 fl ">
			    {$filter.name}:
		    </div>
		    <input type="hidden" name="paraid[]" value="{$filter.dparaid}" />
		    <div class="t_filter_r col-xs-11 fl ">
		        <input type="hidden" name="t_vid[]" value="0" />
			    <ul>
			        <foreach name="filter.value" key="k" item="v">
				    <li >
					    <a href="javascript:;" class="goods_filter">
					    {:strtoupper($v['value'])}
					    <input type="hidden" value="{$v.dvid}" />
					    </a>
				    </li>
				    </foreach>
				    <li >
					    <a href="javascript:;" class="goods_filter">
					    {:L('ADMIN_ALL')}
					    <input type="hidden" value="0" />
					    </a>
				    </li>
			    </ul>
		    </div>
	    </div>
	    </foreach> -->
	    <!-- 胎面宽度 -->
	    <!-- //筛选条件 -->
    </div>
</div><!-- //nav -->

<div class="container-fluid">
    <div class="container">
        <div class="col-xs-12 t_tab">
            <div class="t_tab_l">
                {:L('ADMIN_MATCH')}{:L('ADMIN_GOODS')}
                <em>(<span id="total_rows">{$totalrows}</span>{:L('ADMIN_ITEM')})</em>
            </div>
        </div>
    </div>
</div>
<!-- <div class="container-fluid">
    <div class="container">
        <div class="col-xs-12 t_tab">
            <div class="t_tab_l">
                {:L('ADMIN_GOODS')}{:L('ADMIN_TOTAL')}
                <em>(<span id="total_rows">{$totalrows}</span>{:L('ADMIN_ITEM')})</em>
            </div>
        </div>
    </div>
</div> -->
<!-- goods list -->
<div class="container-fluid">
    <div class="container t_list">
	    <ul class="col-xs-12" id="goodslist">
		    <foreach name="goods" key="key" item="value">
			    <li class="col-xs-12 t_list_li">
				    <div class="t_list_l col-xs-3">
			    		<a href="{:U('Goods/detail',array('goodsid'=>$value['goodsid']))}" class="t_list_img" target="_blank">
			    		<img class="img-responsive" src="<if condition="$value['thumb'] eq ''">{$default_image}<else />{$site_imagedomain}{$value.thumb}</if>" />
			    		</a>
				    </div>
				    <div class="t_list_c col-xs-8 row">
					    <div class="t_list_title">
					    	<a href="{:U('goods/detail',array('goodsid'=>$value['goodsid']))}">{$value.title}</a>
				    	</div>
				    	<div class="t_list_spec">
					    	<ul class="col-xs-12 row">
						    	<li class="col-xs-6 row">
			                        <span>{:L('ADMIN_BRAND')}:</span>
			                        {$value.brand}
		                        </li>
			                    <li class="col-xs-6 row">
			                        <span>{:L('ADMIN_MODEL')}:</span>
			                        {$value.model}
		                        </li>
						    	<foreach name="value.param" key="k" item="v">
							    	<li class="col-xs-6 row">
				                        <span>{$k}:</span>
				                        {$v}
			                        </li>
		                        </foreach>
					    	</ul>
					    </div>
				    </div>
				    <div class="t_list_r col-xs-1 row">
					    <div class="t_list_price">
					    	<if condition="$value['minprice'] neq ''">
                            ￥{$value.minprice}
                            <else />
                            {:L('NO_QUOTATION')}
                            </if>
				    	</div>
					    	<!-- <a href="">联系我们</a> -->
				    </div>
			    </li>
		    </foreach>
	    </ul>
    </div>
</div>
<script type="text/javascript" src="__STATIC__/js/serieslist.js"></script>
<input type="hidden" value="{:L('ADMIN_PREV')}" id="prev_page" />
<input type="hidden" value="{:L('ADMIN_NEXT')}" id="next_page" />
<input type="hidden" value="{:L('ADMIN_TOTAL')}" id="p_total" />
<input type="hidden" value="{:L('ADMIN_PAGE')}" id="d_page" />
<div id="page">
<include file="Public/page"/>
</div>

<include file="Public/footer"/>