<div class="main" >
	<div class="category_detail">
		<div class="category_detail_title">
		    <h2><?php echo $series['series_alias'];?></h2>
		</div>
		<div class="category_body">
		    
			<div class="category_body_l">
			    <ul>
			        <?php if(!empty($series_arr)):?>
			        	<?php foreach ($series_arr as $key => $value): ?>
			        		<li >
							    <a href="<?php echo site_url('series/series_detail/'.$value['seriesid'].'/'.$value['linkurl']);?>" title="<?php echo $value['series_alias'];?>" <?php if(strcmp(strval($value['seriesid']), strval($seriesid)) == 0){ echo 'class="on"' ;}?>>
								    <?php echo $value['series_alias'];?>
							    </a>
						    </li>
			        	<?php endforeach ?>
				    <?php endif ?>
			    </ul>
			</div>
			<div class="category_body_r">
			    <div class="category_body_t_title">
			    	<h3>Product:</h3>
			    </div>
			    <div class="category_body_b">
				    <ul>
				        <?php foreach ($goods as $key => $value): ?>
				    		<li>
				    		    <div class="category_body_b_image">
				    		        <a href="<?php echo site_url('goods/goods_detail/'.$value['goodsid'].'/'.$value['linkurl']);?>" title="<?php echo $value['en_title'];?>" > 
						    		    <img class="lazy"  src="<?php echo $site['image_default'];?>" data-original="<?php echo $site['image_domain'].$value['thumb'];?>" alt="<?php echo $value['en_title'];?>"  title="<?php echo $value['en_title'];?>" />
					    		    </a>
				    		    </div>
				    		    <div class="category_body_b_title">
					    		    <a href="<?php echo site_url('goods/goods_detail/'.$value['goodsid'].'/'.$value['linkurl']);?>" title="<?php echo $value['en_title'];?>" >
						    		    <?php echo $value['en_title'];?>
					    		    </a>
				    		    </div>
				    		</li>
			    		<?php endforeach ?>
			    	</ul>
			    </div>
			    <div class="category_body_t">
			    	<ul>
			    		<?php echo $page;?>
			    	</ul>
			    </div>
			</div>
		</div>
	</div>
</div>
