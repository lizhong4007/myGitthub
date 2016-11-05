<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/serieslist.css">
<!-- 页面标题 -->
<input type="hidden" value="{$brand['brand_name']}-{$nav_series['series_name']}-{$current_category.cat_name}-bmbmda.com" id="site_title" />
<input type="hidden" value="{$brand['brand_name']} {$nav_series['series_name']} {$current_category.cat_name} 花纹 速度级别 尺寸 扁平比 帘布层评级" id="site_keywords" />
<input type="hidden" value="{$brand['brand_name']}轮胎下的不同花纹" id="site_description" />
<!-- //页面标题 -->
<div class="container-fluid -slide-body">
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
</div>
<!-- nav -->
<div class="container-fluid">
    <div class="container all_selector">
	    <div class="t_selector col-xs-12">
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
						    {$brand.brand_name}
					    </div>
				    </li>
			    </ul>
		    </div>
	    </div>
	    <!-- 筛选条件 扁平率 -->
	    <input type="hidden" value="{:U('Series/get_filter_goods')}" id="filter_url" />
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
	    </foreach>
	    <!-- 胎面宽度 -->
	    <!-- //筛选条件 -->
    </div>
</div><!-- //nav -->

<div class="container-fluid">
    <div class="container">
        <div class="col-xs-12 t_tab">
            <div class="t_tab_l">
                {:L('ADMIN_GOODS')}{:L('ADMIN_TOTAL')}
                <em>(<span id="total_rows">{$page.totalRows}</span>{:L('ADMIN_ITEM')})</em>
            </div>
        </div>
    </div>
</div>
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
<link rel="stylesheet" href="__STATIC__/css/page.css" />
<input type="hidden" value="{:L('ADMIN_PREV')}" id="prev_page" />
<input type="hidden" value="{:L('ADMIN_NEXT')}" id="next_page" />
<input type="hidden" value="{:L('ADMIN_TOTAL')}" id="p_total" />
<input type="hidden" value="{:L('ADMIN_PAGE')}" id="d_page" />
<div id="page">
	<!-- page -->
	<div class="container-fluid page">
	    <div class="container ">
	        <div class="page_num">
	            <ul>
	                <if condition="$page['prev'] neq ''">
	                    <li class="pre">
	                        <a href="{$page.prev}">{:L('ADMIN_PREV')}</a>
	                    </li>
	                </if>
	                <foreach name="page.page" key="key" item="pageurl">
	                <if condition="$pageurl  eq 'current'">
	                    <li class="num active">
	                        <a href="#">{$key}</a>
	                    </li>
	                <else />
	                    <li class="num ">
	                        <a href="{$pageurl}">{$key}</a>
	                    </li>
	                </if>
	                </foreach>
	               <if condition="$page['next'] neq ''">
	                    <li class="next">
	                        <a href="{$page.next}">{:L('ADMIN_NEXT')}</a>
	                    </li>
	                </if>
	                <if condition="count($page['page']) gt 1">
	                <li class="total">
	                    共{$page.totalPages}页
	                </li>
	                <li class="page_go">
	                    <div class="form-group">
	                        <div class="input-group">
	                        <input class="form-control" id="goto_page"  value="" type="text">
	                        <input type="hidden" value="{$page.org_url}" id="org_url" />
	                        <span class="input-group-addon goto_page">
	                        GO
	                        </span>
	                        </div>
	                    </div>
	                </li>
	                </if>
	            </ul>
	        </div>
	    </div>
	</div><!-- //page -->

</div>
<script type="text/javascript">
$(".goto_page").on("click",function(){
    var p_value = $("#goto_page").val();
    var org_url = $("#org_url").val();
    p_value = parseInt(p_value);
    if(p_value > 0)
    {
        var parter = /\[PAGE\]/g;
        var url = org_url.replace(parter,p_value);
        window.location.href = url; 
    }
})
$(".t_selector_brand").hover(function(){
		var obj = $(this);
		obj.find(".t_selector_img").css({"display":"none"});
		obj.find(".t_selector_title").css({"display":"block"});

	},function(){
		var obj = $(this);
		obj.find(".t_selector_title").css({"display":"none"});
		obj.find(".t_selector_img").css({"display":"block"});
	});
</script>
<include file="Public/footer"/>