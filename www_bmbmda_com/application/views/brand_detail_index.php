<div class="main" >
	<div class="category_detail">
		<div class="category_detail_title">
		    <h2><?php echo $brand['brand_alias'];?></h2>
		</div>
		<div class="category_body">
		    
			<div class="category_body_l">
			    <ul>
			        <?php if(!empty($category)):?>
			        	<li >
						    <a href="<?php echo site_url('brand/brand_detail/'.$brand['brandid'].'/'.$brand['linkurl']);?>" title="<?php echo $brand['brand_alias'];?>">
							    All
						    </a>
					    </li>
			        	<?php foreach ($category as $key => $value): ?>
			        		<li >
							    <a href="<?php echo site_url('brand/brand_detail/'.$brand['brandid'].'_'.$value['catid'].'/'.$brand['linkurl']);?>" title="<?php echo $value['cat_alias'];?>" <?php if(strcmp(strval($value['catid']), strval($catid)) == 0){ echo 'class="on"' ;}?>>
								    <?php echo $value['cat_alias'];?>
							    </a>
						    </li>
			        	<?php endforeach ?>
				    <?php endif ?>
			    </ul>
			</div>

			<div class="category_body_r">
			    <div class="category_body_t">
			    	<ul>
			    		<?php echo $page;?>
			    	</ul>
			    </div>
			    <div class="category_body_b">
				    <ul>
				        <?php foreach ($series as $key => $value): ?>
				    		<li>
				    		    <div class="category_body_b_image">
				    		        <a href="<?php echo site_url('series/series_detail/'.$value['seriesid'].'/'.$value['linkurl']);?>" title="<?php echo $value['series_alias'];?>" > 
						    		    <img class="lazy"  src="<?php echo $site['image_default'];?>" data-original="<?php echo $site['image_domain'].$value['thumb'];?>" alt="<?php echo $value['series_alias'];?>"  title="<?php echo $value['series_alias'];?>" />
					    		    </a>
				    		    </div>
				    		    <div class="category_body_b_title">
					    		    <a href="<?php echo site_url('series/series_detail/'.$value['seriesid'].'/'.$value['linkurl']);?>" title="<?php echo $value['series_alias'];?>" >
						    		    <?php echo $value['series_alias'];?>
					    		    </a>
				    		    </div>
				    		</li>
			    		<?php endforeach ?>
			    	</ul>
			    </div>
			</div>
		</div>
	</div>
</div>
