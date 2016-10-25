<include file="Public/header"/>
<link rel="stylesheet" href="__STATIC__/css/homepage.css">
<script src="__STATIC__/slider/jquery.SuperSlide.2.1.1.js"></script>
<script src="__STATIC__/js/home.js"></script>
<!-- slide -->
<div class="container-fluid slide-body">
    <div class="container">
        <div class="col-xs-12 slide">
            <div class="col-xs-3 slide_l">
                <ul class=" category_ul">
                    <foreach name="category" key="key" item="cate">
                        <if condition="$cate['is_show'] eq '1' and $cate['parentid'] eq '0'">
                            <li class="p_category" data-index="{$key}" id="pcat_{$key}">
                                <a href="{:U('Goods/goods_list',array('catid'=>$cate['catid']))}">{$cate.cat_name}</a>
                            </li>
                        </if>
                    </foreach>                    
                </ul>
            </div>
            <div class="col-xs-9 slide_r" id="slide_box">
                <div id="slideBox" class="col-xs-12 slideBox">
                    <div class="slide_dot hd">
                        <ul>
                            <li>1</li>
                            <li>2</li>
                            <li>3</li>
                        </ul>
                    </div>
                    <div class="bd slider">
                        <ul>
                            <li>
                                <a href="#" target="_blank"><img src="http://www.superslide2.com/demo/images/pic1.jpg" /></a>
                            </li>
                            <li>
                                <a href="#" target="_blank"><img src="http://www.superslide2.com/demo/images/pic2.jpg" /></a>
                            </li>
                            <li>
                                <a href="#" target="_blank"><img src="http://www.superslide2.com/demo/images/pic3.jpg" /></a>
                            </li>
                        </ul>
                    </div>
                    <!-- arrow -->
                    <a class="prev" href="javascript:void(0)"></a>
                    <a class="next" href="javascript:void(0)"></a>
                </div>
            </div>
            <!-- sub-category -->
            <foreach name="category" key="key" item="cate">
                <if condition="$cate['is_show'] eq '1' and $cate['parentid'] eq '0'">
                    <div class="col-xs-9 slide_r sub_category" data-index="{$key}" id="sub_{$key}">
                        <ul class="col-xs-12 row">
                            <foreach name="category" key="k" item="sub_cate">
                                <if condition="$sub_cate['parentid'] eq $key">
                                    <li class="col-xs-4 ">
                                       <a href="{:U('Goods/goods_list',array('catid'=>$sub_cate['catid']))}">{$sub_cate.cat_name}</a>
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
        <div class="col-xs-12 tab">
            <div class="tab_l">
                {:L('ADMIN_GOODS')}{:L('ADMIN_TOTAL')}
                <em>({$page.totalRows}{:L('ADMIN_ITEM')})</em>
            </div>
            <div class="tab_r">
                <ul>
                    <li class="-active">
                        <a href="">{:L('ADMIN_NEW')}</a>
                    </li>
                    <li>
                        <a href="">{:L('ADMIN_HOT')}</a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>
<!-- 商品列表开始 -->
<div class="container-fluid">
    <div class="container">
        <div class="col-xs-12 goodslist">
            <ul class="goodslist_ul">
                <foreach name="goods_data" key="key" item="value">
                    <li class="col-xs-3 goodslist_block">
                        <div class="col-xs-12 goodsthumb ">
                            <div class="goods_img">
                            <a  target="_blank" href="{:U('Goods/detail',array('goodsid'=>$value['goodsid']))}">
                                <img  class="img-responsive" src="<if condition="$value['thumb'] eq ''">{$default_image}<else />{$site_imagedomain}{$value.thumb}</if>" />
                            </a>
                            </div>
                            <div class="goods_brand">
                               {$value.brand}
                            </div>
                            <div class="goods_model">
                                <a target="_blank" href="{:U('Goods/detail',array('goodsid'=>$value['goodsid']))}">{$value.model}</a>
                                <em>
                                    <if condition="$value['min_price'] neq 0.00">
                                    ￥{$value.min_price}
                                    <else />
                                    {:L('NO_QUOTATION')}
                                    </if>
                                </em>
                            </div>
                            <div class="goods_spec">
                                <ul>
                                    <foreach name="value.param" key="k" item="para">
                                        <li>
                                        <span>{$k}:</span>{$para}
                                        </li>
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


<include file="Public/page" />
<include file="Public/footer"/>
