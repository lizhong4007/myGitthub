<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/serieslist.min.css">

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
    <div class="container ">
	    <div class="all_selector ">
		    <div class="t_selector">
			    <div class="t_selector_l">
				    {:L('ADMIN_BRAND')}:
			    </div>

			    <div class="t_selector_r">
				    <ul class="">
					    <li class="t_selector_brand">
					    	<div class="t_selector_img">
						    	<img title="{$brand.brand_name}" alt="{$brand.brand_name}"  src="<if condition="$brand['thumb'] eq ''">{$default_image}<else />{$site_imagedomain}{$brand.thumb}</if>" />
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
		     <div class="t_filter">
			    <div class="t_filter_l fl ">
				    {$filter.name}:
			    </div>
			    <input type="hidden" name="paraid[]" value="{$filter.dparaid}" />
			    <div class="t_filter_r fl ">
			        <input type="hidden" name="t_vid[]" value="0" />
				    <ul>
				        <foreach name="filter.value" key="k" item="v">
					    <li >
						    <a href="javascript:;" class="goods_filter" rel="nofollow">
						    {:strtoupper($v['value'])}
						    <input type="hidden" value="{$v.dvid}" />
						    </a>
					    </li>
					    </foreach>
					    <li >
						    <a href="javascript:;" class="goods_filter" rel="nofollow">
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
    </div>
</div><!-- //nav -->

<div class="container-fluid">
    <div class="container">
        <div class="t_tab">
            <div class="t_tab_l">
                {:L('ADMIN_GOODS')}{:L('ADMIN_TOTAL')}
                <em>(<span id="total_rows">{$page.totalRows}</span>{:L('ADMIN_ITEM')})</em>
            </div>
        </div>
    </div>
</div>
<!-- goods list -->
<input type="hidden" value="{$site_imagedomain}" id="site_imagedomain" />
<div class="container-fluid">
    <div class="container ">
	    <div class=" t_list">
		    <ul class="t_list_ul" id="goodslist">
			    <foreach name="goods" key="key" item="value">
				    <li class="t_list_li">
					    <div class="t_list_l">
				    		<a title="{$value.title}" href="{:U('Goods/detail',array('goodsid'=>$value['goodsid']))}" class="t_list_img" target="_blank">
					    		<img title="{$value.title}" alt="{$value.title}"  class="img-responsive lazy" src="{$default_image}" data-original="{$site_imagedomain}{$value.thumb}" />
				    		</a>
					    </div>
					    <div class="t_list_c">
						    <div class="t_list_title">
						    	<a title="{$value.title}" href="{:U('goods/detail',array('goodsid'=>$value['goodsid']))}">{$value.title}</a>
					    	</div>
					    	<div class="t_list_spec">
						    	<ul >
							    	<li >
				                        <span>{:L('ADMIN_BRAND')}:</span>
				                        {$value.brand}
			                        </li>
				                    <li >
				                        <span>{:L('ADMIN_MODEL')}:</span>
				                        {$value.model}
			                        </li>
							    	<foreach name="value.param" key="k" item="goods_param">
								    	<li >
					                        <span>{$goods_param['param']}:</span>
					                        {$goods_param['value']}
				                        </li>
			                        </foreach>
						    	</ul>
						    </div>
					    </div>
					    <div class="t_list_r">
						    <div class="t_list_price">
						    	<if condition="strcmp($value['min_price'],'0.00') neq 0">
		                            {$value.currency}{$value.min_price}
	                            <else />
	                            <!-- {:L('NO_QUOTATION')} -->
	                            </if>
					    	</div>
						    	<!-- <a href="">联系我们</a> -->
					    </div>
				    </li>
			    </foreach>
		    </ul>
	    </div>
    </div>
</div>

<link rel="stylesheet" href="__STATIC__/css/page.min.css" />
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
<script src="__STATIC__/js/jQuery-2.1.4.min.js"></script>
<script type="text/javascript" src="__STATIC__/js/serieslist.min.js"></script>
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