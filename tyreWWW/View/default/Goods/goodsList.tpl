<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/goodslist.css">
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
    			{$current_category.cat_name}
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
		    <if condition="count($brand) gt 6">
			    <div class="t_selector_more">
				    <a href="javascript:;">{:L('ADMIN_SPREAD')}</a>
				    <i class="opened"></i>
			    </div>
		    </if>
		    <div class="t_selector_r col-xs-11">
			    <ul class=" col-xs-12 row">
				    <foreach name="brand" key="key" item="value">
					    <li class="col-xs-2 row t_selector_brand">
					    	<div class="t_selector_img">
						    	<img  src="<if condition="$value['thumb'] eq ''"> {$default_image} <else />{$site_imagedomain}{$value.thumb}</if>" />
						    </div>
						    <div class="t_selector_title">
							    <input type="hidden" value="{$value.brandid}" class="brand_id" />
						    	<a href="javascript:;" class="select_brand">{$value.brand_name}</a>
						    </div>
					    </li>

				    </foreach>
			    </ul>
		    </div>
	    </div>
	     <div class="t_filter col-xs-12">
		    <div class="t_filter_l col-xs-1 ">
			    {:L('ADMIN_SERIES')}:
		    </div>
		    <if condition="count($series) gt 6">
			    <div class="t_filter_more">
				    <a href="javascript:;">{:L('ADMIN_SPREAD')}</a>
				    <i class="opened"></i>
			    </div>
		    </if>
		    <div class="t_filter_r col-xs-10 ">
		    <input type="hidden" value="{:U('Goods/get_series')}" id="get_series_url" />
			    <ul id="series_list">
			        <foreach name="series" key="key" item="value">
				    <li >
					    <a href="{:U('Goods/series_list',array('seriesid'=>$value['seriesid']))}">
					    {$value.series_name}
					    </a>
				    </li>
				    </foreach>

			    </ul>
		    </div>
	    </div>
    </div>
</div><!-- //nav -->

<div class="container-fluid">
    <div class="container">
        <div class="col-xs-12 t_tab">
            <div class="t_tab_l">
                {:L('ADMIN_GOODS')}{:L('ADMIN_TOTAL')}
                <em>({$page.totalRows}{:L('ADMIN_ITEM')})</em>
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
			obj.parent().find(".t_selector_brand").css({"margin-top":"10px"});
		}else{
			$("#closed").val("0");
			obj.find("a").html(opened);
			obj.removeClass("active");
			obj.find("i").removeClass("closeing");
			obj.find("i").addClass("opened");
			obj.find("a").removeClass("a_color");
			obj.parent().find(".t_selector_r").css({"height":"50px"});
			obj.parent().find(".t_selector_brand").css({"margin-top":"auto"});
		}
	});
	/*赛选条件更多*/
	$(".t_filter_more").on("click",function(){
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
			obj.parent().find(".t_filter_r ul").css({"height":"auto"});
		}else{
			$("#closed").val("0");
			obj.find("a").html(opened);
			obj.removeClass("active");
			obj.find("i").removeClass("closeing");
			obj.find("i").addClass("opened");
			obj.find("a").removeClass("a_color");
			obj.parent().find(".t_filter_r ul").css({"height":"40px"});
		}
	});
</script>
<script type="text/javascript">
	$('.select_brand').on('click',function(){
		var obj = $(this);
		obj.parent().parent().parent().find('.t_selector_img').css({'border':'1px solid #e7e7e7'});
		obj.parent().parent().find('.t_selector_img').css({'border':'1px solid #C81623'});
		var brand_id = obj.parent().find('.brand_id').val();
		var cat_id = $('#cat_id').val();
		var url = $('#get_series_url').val();
		$.ajax({
			url:url,
			type:'post',
			dataType:'json',
			data:{cat_id:cat_id,brand_id:brand_id},
			success:function(json){
				var data = json.message;
				if(json.code == 1)
				{
					var str = '';
					for (var i = 0; i < data.length; i++) {
						str += '<li >';
						str += '<a href="/Goods/goods_list/catid/'+cat_id+'/seriesid/'+data[i].seriesid+'">';
						str += data[i].series_name;
						str += '</a>';
						str += '</li>';
					}
					$('#series_list').html(str);
				}
			}

		});
	});
</script>
<include file="Public/page" />
<include file="Public/footer"/>