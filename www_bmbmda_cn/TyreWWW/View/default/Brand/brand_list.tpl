<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/brandlist.css">
<!-- //页面标题 -->
<div class="container-fluid -slide-body">
    <div class="container">
    <div class="t_nav">
    	<ul>
    		<li>
    			<a href="/">{:L("ADMIN_HOME")}</a>
    			<i>></i>
    		</li>
    		<li>
    			{:L("BRAND_ZONE")}
    		</li>
    	</ul>
    </div>
    </div>
</div>
<!-- nav -->
<div class="container-fluid">
    <div class="container all_selector">
        <input type="hidden" value="0" id="closed" />
        <input type="hidden" value="{:L('ADMIN_CLOSE')}" id="closeing" />
        <input type="hidden" value="{:L('ADMIN_SPREAD')}" id="opened" />
        <input type="hidden" value="{$catid}" id="cat_id" />
	    <div class="t_selector width1200 fl">
		    <div class="t_selector_l width100 fl">
			    {:L('ADMIN_BRAND')}
		    </div>
		    <if condition="count($brand) gt 6">
			    <div class="t_selector_more">
				    <a href="javascript:;">{:L('ADMIN_SPREAD')}</a>
				    <i class="opened"></i>
			    </div>
		    </if>
		    <div class="t_selector_r width1000 fl">
		    <input type="hidden" value="{:U('Brand/get_brand_goods')}" id="brand_url" />
			    <ul class="width1000">
				    <foreach name="brand" key="key" item="value">
					    <li class="t_selector_brand">
					    	<div class="t_selector_img">
					    	<input type="hidden" value="{$value.brandid}" class="brand_id" />
					    	    <if condition="$value['thumb'] eq ''">
					    	        <img title="{$value.brand_name}" alt="{$value.brand_name}"  class="img-responsive"  src=" {$default_image}" />
					    	    <else />
							    	<img  title="{$value.brand_name}" alt="{$value.brand_name}" class="img-responsive"  src="{$site_imagedomain}{$value.thumb}" />
						    	</if>
						    </div>
						    <div class="t_selector_title">
						    	<a  href="{:U('Brand/brand_list',array('brandid'=>$value['brandid']))}" class="select_brand">
							    	{$value.brand_name}
						    	</a>
						    </div>
					    </li>

				    </foreach>
			    </ul>
		    </div>
	    </div>
    </div>
</div><!-- //nav -->

<div class="container-fluid">
    <div class="container t_list">
    </div>
</div>

<notempty name = "goods">
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
    <div class="container t_list brand_goods">
	    <ul class="width1200" id="goodslist">
		    <foreach name="goods" key="key" item="value">
			    <li class="width1200 brand_goods_li">
				    <div class="brand_goods_l width300 fl">
			    		<a href="{:U('goods/detail',array('goodsid'=>$value['goodsid']))}" class="t_list_img" target="_blank">
				    		<img title="{$value.title}" alt="{$value.title}"  class="img-responsive lazy" src="{$default_image}" data-original="{$site_imagedomain}{$value.thumb}" />
			    		</a>
				    </div>
				    <div class="brand_goods_c width600 fl ">
					    <div class="brand_goods_title">
					    	<a title="{$value.title}" href="{:U('goods/detail',array('goodsid'=>$value['goodsid']))}">
					    	{$value.title}
					    	</a>
				    	</div>
				    	<div class="brand_goods_spec">
					    	<ul class="width600 ">
						    	<li class="width300 ">
			                        <span>{:L('ADMIN_BRAND')}:</span>
			                        {$value.brand}
		                        </li>
			                    <li class="width300 ">
			                        <span>{:L('ADMIN_MODEL')}:</span>
			                        {$value.model}
		                        </li>
						    	<foreach name="value.param" key="k" item="para">
							    	<li class="width300 ">
				                        <span>{$para['param']}:</span>
				                        {$para['value']}
			                        </li>
		                        </foreach>
					    	</ul>
					    </div>
				    </div>
				    <div class="brand_goods_r width300 fl">
					    <div class="brand_goods_price">
					    	<if condition="strcmp($value['min_price'],'0.00') neq 0">
                            {$value.currency}{$value.min_price}
                            <else />
                            <!-- {:L('NO_QUOTATION')} -->
                            </if>
				    	</div>
					    	<!-- <a href="">联系我们</a> -->
				    </div>
				    <div class="clear"></div>
			    </li>
		    </foreach>
	    </ul>
    </div>
</div>
</notempty>

<link rel="stylesheet" href="__STATIC__/css/page.min.css" />
<input type="hidden" value="{:L('ADMIN_PREV')}" id="prev_page" />
<input type="hidden" value="{:L('ADMIN_NEXT')}" id="next_page" />
<input type="hidden" value="{:L('ADMIN_TOTAL')}" id="p_total" />
<input type="hidden" value="{:L('ADMIN_PAGE')}" id="d_page" />
<input type="hidden" value="{$site_imagedomain}" id="site_imagedomain" />
<input type="hidden" value="0" id="brandid_tmp" />
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
<script type="text/javascript" src="__STATIC__/js/brandlist.min.js"></script>
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
});
	$(".t_selector_brand").hover(function(){
		var obj = $(this);
		obj.find(".t_selector_img").css({"display":"none"});
		obj.find(".t_selector_title").css({"display":"block"});

	},function(){
		var obj = $(this);
		obj.find(".t_selector_title").css({"display":"none"});
		obj.find(".t_selector_img").css({"display":"block"});
	});

	$(".t_selector_more").hover(function(){
		var obj = $(this);
		obj.find("i").removeClass("opened");
		obj.find("i").addClass("closed");
		obj.addClass("active");

	},function(){
		var obj = $(this);
		obj.find("i").removeClass("closed");
		obj.find("i").addClass("opened");
		obj.removeClass("active");
	});
	$(".t_filter_more").hover(function(){
		var obj = $(this);
		obj.find("i").removeClass("opened");
		obj.find("i").addClass("closed");
		obj.addClass("active");

	},function(){
		var obj = $(this);
		obj.find("i").removeClass("closed");
		obj.find("i").addClass("opened");
		obj.removeClass("active");
	});	

</script>
<script type="text/javascript">
	/*更多*/
	$(".t_selector_more").on("click",function(){
		var obj = $(this);
		var html = obj.find("a").html();
		var closed = $("#closed").val();
		var closeing = $("#closeing").val();
		var opened = $("#opened").val();
		if(closed == 0)
		{
			$("#closed").val("1");
			obj.find("a").html(closeing);
			obj.addClass("active");
			obj.find("i").removeClass("opened");
			obj.find("i").addClass("closeing");
			obj.find("a").addClass("a_color");
			obj.parent().find(".t_selector_r").css({"height":"auto"});
		}else{
			$("#closed").val("0");
			obj.find("a").html(opened);
			obj.removeClass("active");
			obj.find("i").removeClass("closeing");
			obj.find("i").addClass("opened");
			obj.find("a").removeClass("a_color");
			obj.parent().find(".t_selector_r").css({"height":"60px"});
		}
	});
	
</script>

<include file="Public/footer"/>