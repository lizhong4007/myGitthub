<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/brandlist.css">
<!-- 页面标题 -->
<input type="hidden" value="{:L('BRAND_ZONE')}-{$default_title}" id="site_title" />
<input type="hidden" value="米其林 邓禄普 {:L('BRAND_ZONE')} 轮胎品牌 轮胎" id="site_keywords" />
<input type="hidden" value="{$default_title}|{:L('BRAND_ZONE')},各种各样的轮胎品牌" id="site_description" />
<!-- //页面标题 -->
<div class="container-fluid -slide-body">
    <div class="container">
    <div class="t_nav">
    	<ul>
    		<li>
    			<a href="{:U('HomePage/index')}">{:L("ADMIN_HOME")}</a>
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
	    <div class="t_selector col-xs-12">
		    <div class="t_selector_l col-xs-1">
			    {:L('ADMIN_BRAND')}
		    </div>
		    <if condition="count($brand) gt 10">
			    <div class="t_selector_more">
				    <a href="javascript:;">{:L('ADMIN_SPREAD')}</a>
				    <i class="opened"></i>
			    </div>
		    </if>
		    <div class="t_selector_r col-xs-11">
			    <ul class=" col-xs-12 ">
				    <foreach name="brand" key="key" item="value">
					    <li class="col-xs-2  t_selector_brand">
					    	<div class="t_selector_img">
						    	<img  src="<if condition="$value['thumb'] eq ''"> {$default_image} <else />{$site_imagedomain}{$value.thumb}</if>" />
						    </div>
						    <div class="t_selector_title">
							    <input type="hidden" value="{$value.brandid}" class="brand_id" />
						    	<a  href="{:U('series/series_list',array('seriesid'=>$value['series']['seriesid']))}" class="select_brand">{$value.brand_name}</a>
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
                <em>({$page.totals}{:L('ADMIN_ITEM')})</em>
            </div>
        </div>
    </div>
</div>
<!-- goods list -->
<div class="container-fluid">
    <div class="container t_list">
	    <ul class="col-xs-12">
		    <foreach name="goods" key="key" item="value">
			    <li class="col-xs-12 t_list_li">
				    <div class="t_list_l col-xs-3">
			    		<a href="{:U('goods/detail',array('goodsid'=>$value['goodsid']))}" class="t_list_img" target="_blank">
			    		<img class="img-responsive" src="<if condition="$value['thumb'] eq ''"> {$default_image} <else />{$site_imagedomain}{$value.thumb}</if>" />
			    		</a>
				    </div>
				    <div class="t_list_c col-xs-8 ">
					    <div class="t_list_title">
					    	<a href="{:U('goods/detail',array('goodsid'=>$value['goodsid']))}">{$value.title}</a>
				    	</div>
				    	<div class="t_list_spec">
					    	<ul class="col-xs-12 ">
						    	<li class="col-xs-6 ">
			                        <span>{:L('ADMIN_BRAND')}:</span>
			                        {$value.brand}
		                        </li>
			                    <li class="col-xs-6 ">
			                        <span>{:L('ADMIN_MODEL')}:</span>
			                        {$value.model}
		                        </li>
						    	<foreach name="value.param" key="k" item="v">
							    	<li class="col-xs-6 ">
				                        <span>{$k}:</span>
				                        {$v}
			                        </li>
		                        </foreach>
					    	</ul>
					    </div>
				    </div>
				    <div class="t_list_r col-xs-1 ">
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
</notempty>
<script type="text/javascript">
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
			obj.parent().find(".t_selector_r").css({"height":"120px"});
		}
	});
	
</script>

<include file="Public/footer"/>