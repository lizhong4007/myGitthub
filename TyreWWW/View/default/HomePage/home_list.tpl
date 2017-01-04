<include file="Public/header"/>
<link rel="stylesheet" href="__STATIC__/css/homepage.min.css">
<!-- slide -->
<div class="container-fluid slide-body">
    <div class="container">
        <div class=" slide">
            <div class=" slide_l">
                <ul class=" category_ul">
                    <foreach name="category" key="key" item="cate">
                        <if condition="$cate['is_show'] eq '1' and $cate['parentid'] eq '0'">
                            <li class="p_category" data-index="{$key}" id="pcat_{$key}">
                                <a href="{:U('Goods/goods_list',array('catid'=>$cate['catid']))}" title="{$cate.cat_name}">{$cate.cat_name}</a>
                            </li>
                        </if>
                    </foreach>                    
                </ul>
            </div>
            <div class=" slide_r" id="slide_box">
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
                            <li>
                                <a href="{:U('goods/detail',array('goodsid'=>$recommed_goods[0]['goodsid']))}" target="_blank">
                                    <img  src="__STATIC__/images/slide1.png" alt="bmbmda.com" />
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- arrow -->
                    <!-- <a class="prev" href="javascript:void(0)"></a>
                    <a class="next" href="javascript:void(0)"></a> -->
                </div>
            </div>
            <!-- sub-category -->
            <foreach name="category" key="key" item="cate">
                <if condition="$cate['is_show'] eq '1' and $cate['parentid'] eq '0'">
                    <div class=" slide_r sub_category" data-index="{$key}" id="sub_{$key}">
                        <ul class=" row">
                            <foreach name="category" key="k" item="sub_cate">
                                <if condition="$sub_cate['parentid'] eq $key and $sub_cate['status'] eq 1">
                                    <li class="col-xs-4 ">
                                       <a href="{:U('Goods/goods_list',array('catid'=>$sub_cate['catid']))}" title="{$sub_cate.cat_name}">{$sub_cate.cat_name}</a>
                                    </li>
                                </if>
                            </foreach>
                        </ul>
                    </div>
                </if>
            </foreach>
            <!-- //sub-category -->
        </div>
    </div>
</div><!-- //slide -->
<div class="container-fluid">
    <div class="container">
        <div class=" tab">
            <div class="tab_l">
                {:L('ADMIN_GOODS')}{:L('ADMIN_TOTAL')}
                <em>({$page.totalRows}{:L('ADMIN_ITEM')})</em>
            </div>
            <div class="tab_r">
                <ul>
                    <li>
                        <a href="{:U('HomePage/index')}" rel="nofollow">全部</a>
                    </li>
                    <li <if condition="$ip eq 1">class="active"</if>>
                        <a href="{:U('HomePage/index',array('ip'=>1))}" rel="nofollow">国产</a>
                    </li>
                    <li <if condition="$ip eq 2">class="active"</if>>
                        <a href="{:U('HomePage/index',array('ip'=>2))}" rel="nofollow">进口</a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>
<!-- 商品列表开始 -->
<div class="container-fluid">
    <div class="container">
        <div class=" goodslist">
            <ul class="goodslist_ul">
                <foreach name="goods_data" key="key" item="value">
                    <li class="goodslist_block">
                        <div class=" goodsthumb ">
                            <div class="goods_img">
                            <a title="{$value.title}"  target="_blank" href="{:U('Goods/detail',array('goodsid'=>$value['goodsid']))}">
                                <img title="{$value.title}" alt="{$value.title}"  class="lazy" src="{$default_image}" data-original="{$site_imagedomain}{$value.thumb}" />
                            </a>
                            </div>
                            <div class="goods_brand">
                               {$value.brand}
                            </div>
                            <div class="goods_model">
                                <a title="{$value.title}" target="_blank" href="{:U('Goods/detail',array('goodsid'=>$value['goodsid']))}">{$value.model}</a>
                                <em>
                                    <if condition="$value['min_price'] neq 0.00">
                                    ￥{$value.min_price}
                                    <else />
                                        <if condition="$value['is_import'] eq 1">
                                           国产
                                           <elseif condition="$value['is_import'] eq 2" />进口
                                           <else />
                                            <!-- {:L('NO_QUOTATION')} -->
                                        </if>
                                    </if>
                                </em>
                            </div>
                            <div class="goods_spec">
                                <ul>
                                    <foreach name="value.param" key="k" item="para">
                                        <if condition="$k lt 6">
                                            <li>
                                            <span>{$para['param']}:</span>
                                            {$para['value']}
                                            </li>
                                        </if>
                                    </foreach>
                                </ul>
                            </div>
                        </div>
                    </li>
                 </foreach>  
            </ul>
        </div><!-- //goodslist -->
    </div>
</div>
<script src="__STATIC__/js/jQuery-2.1.4.min.js"></script>
<script src="__STATIC__/slider/jquery.SuperSlide.2.1.1.min.js"></script>
<script src="__STATIC__/js/home.min.js"></script>
<include file="Public/page" />
<include file="Public/footer"/>
