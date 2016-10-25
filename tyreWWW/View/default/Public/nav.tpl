<div class="container-fluid -slide-body">
    <div class="container">
    <div class="t_nav">
    	<ul>
    		<li>
    			<a href="{:U('Home/index')}">首页</a>
    			<i>></i>
    		</li>
            <if condition="$parent_category neq ''">
        		<li>
        			<a href="">{$parent_category['cat_name']}</a>
        			<i>></i>
        		</li>
            </if>
    		<li>
    			<a href="">{$current_category['cat_name']}</a>
    			<i>></i>
    		</li>
            <if condition="$nav_series neq ''">
                <li>
                    <a href="{:U("Goods/series",array("seriesid"=>$goods['seriesid']))}">{$nav_series['series_name']}</a>
                    <i>></i>
                </li>
            </if>
            <if condition="$nav_model neq ''">
        		<li>{$nav_model['model']}</li>
            </if>
    	</ul>
    </div>
    </div>
</div>