<include file="Public/header"/>
<link rel="stylesheet" type="text/css" href="__STATIC__/css/searchlist.min.css">

<div class="container-fluid">
    <div class="container all_selector">
	    
    </div>
</div><!-- //nav -->

<div class="container-fluid">
    <div class="container">
        <div class="width1200 t_tab fl">
            <div class="t_tab_l">
                {:L('ADMIN_MATCH')}{:L('ADMIN_GOODS')}
                <em>(<span id="total_rows">{$totalrows}</span>{:L('ADMIN_ITEM')})</em>
            </div>
        </div>
    </div>
</div>
<!-- goods list -->
<div class="container-fluid">
    <div class="container ">
    <div class=" t_list width1200 fl">
	    <ul class="width1200" id="goodslist">
		    <foreach name="goods" key="key" item="value">
			    <li class="width1200 fl t_list_li">
				    <div class="t_list_l width300 fl">
			    		<a title="{$value.title}" href="{:U('Goods/detail',array('goodsid'=>$value['goodsid']))}" class="t_list_img" target="_blank">
			    		    <img title="{$value.title}" alt="{$value.title}"  class="img-responsive lazy" src="{$default_image}" data-original="{$site_imagedomain}{$value.thumb}" />
			    		</a>
				    </div>
				    <div class="t_list_c width600 fl">
					    <div class="t_list_title width600">
					    	<a href="{:U('goods/detail',array('goodsid'=>$value['goodsid']))}">
						    	{$value.title}
					    	</a>
				    	</div>
				    	<div class="t_list_spec width600">
					    	<ul class="width600">
						    	<li class="width300 fl">
			                        <span>{:L('ADMIN_BRAND')}:</span>
			                        {$value.brand}
		                        </li>
			                    <li class="width300 fl">
			                        <span>{:L('ADMIN_MODEL')}:</span>
			                        {$value.model}
		                        </li>
						    	<foreach name="value.param" key="k" item="goods_param">
							    	<li class="width300 fl">
				                        <span>{$goods_param['param']}:</span>
				                        {$goods_param['value']}
			                        </li>
		                        </foreach>
					    	</ul>
					    </div>
				    </div>
				    <div class="t_list_r width300 fl">
					    <div class="t_list_price">
					    	<if condition="$value['minprice'] neq ''">
                            ￥{$value.minprice}
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
<input type="hidden" value="{:L('ADMIN_PREV')}" id="prev_page" />
<input type="hidden" value="{:L('ADMIN_NEXT')}" id="next_page" />
<input type="hidden" value="{:L('ADMIN_TOTAL')}" id="p_total" />
<input type="hidden" value="{:L('ADMIN_PAGE')}" id="d_page" />
<script src="__STATIC__/js/jQuery-2.1.4.min.js"></script>
<div id="page">
<include file="Public/page"/>
</div>
<script type="text/javascript" src="__STATIC__/js/serieslist.min.js"></script>
<include file="Public/footer"/>