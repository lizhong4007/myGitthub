<include file="Public/header"/>
<div class="main">
	<div class="width100 main_nav fl">
		<ul>
		    <notempty name="brand">
				<li >
					<a href="{:U('Brand/brand_list',array('brandid'=>$brand['brandid']))}" title="{$brand.brand_name}">{$brand.brand_name}</a>
				</li>
			</notempty>
			<notempty name="category">
				<li >
					<a href="{:U('Goods/goods_list',array('catid'=>$category['catid']))}" title="{$category.cat_name}">{$category.cat_name}</a>
				</li>
			</notempty>
		</ul>
		<div class="clear"></div>
	</div>

	<div class="goods_goods">
		<div class="goods_goods_title">
			<b>型号</b>
		</div>
		<div class="goods_goods_body">
		    <ul>
		        <foreach name="goods.data" item="value">
				    <li>
					    <a href="{:U('Goods/detail',array('goodsid'=>$value['goodsid']))}" title="{$value.model}">{$value.title}</a>
				    </li>
			    </foreach>
		    </ul>
			<div class="clear"></div>
		</div>
		<div class="goods_goods_page">
			<ul>
			    <if condition="$goods['page']['totalPages'] gt 1">
					<notempty name="goods.page.prev">
					    <li>
						    <a href="{$goods.page.prev}" title="" class="fa fa-angle-left"></a>
					    </li>
				    <else />
					    <li>
						    <a  title="" class="fa fa-angle-left"></a>
					    </li>
				    </notempty>
				    <if condition="$goods['page']['totalPages'] neq 1">
					    <li>
						    {$current_page}
					    </li>
				    </if>
				    <notempty name="goods.page.next">
					    <li>
						    <a href="{$goods.page.next}"  class="fa fa-angle-right"></a>
					    </li>
				    <else />
					    <li>
						    <a   class="fa fa-angle-right"></a>
					    </li>
				    </notempty>
			    </if>
			</ul>
			<div class="clear"></div>

		</div>
	</div>
</div>
<script type="text/javascript" src="__STATIC__/js/jQuery-2.1.4.min.js"></script>
<include file="Public/footer"/>