<link type="text/css" href="<?php echo base_url('public/home/css/category.min.css');?>" rel="stylesheet">
<div class="header_blank"></div>
<div class="main">
    <div class="category">
	    <div class="category_t">
		    <h2><?php echo ucfirst($category['cat_alias']);?></h2>
	    </div>
	    <div class="category_b">
		    <div class="category_l">
			    <ul>
					<li>
						<a href="<?php echo site_url('category/category_detail/'.$category['catid'].'/'.$category['linkurl']);?>" title="<?php echo $category['cat_alias'];?>">
						  All
						</a>
					</li>
			    <?php foreach($brand as $value):?>
				    <li>
					    <a href="<?php echo site_url('category/category_detail/'.$category['catid'].'_'.$value['brandid'].'/'.$category['linkurl']);?>" title="<?php echo $value['brand_alias'];?>">
					    	<?php echo $value['brand_alias'];?>
					    </a>
				    </li>
				<?php endforeach ?>
			    </ul>
			    
		    </div>
		    <div class="category_r">
		        <div class="category_series_t">
			        <ul>
				        <?php foreach($series as $value):?>
						    <li>
							    <a href="<?php echo site_url('series/series_detail/'.$value['seriesid'].'/'.$value['linkurl']);?>" title="<?php echo $value['series_alias'];?>">
							    	<?php echo $value['series_alias'];?>
							    </a>
						    </li>
					    <?php endforeach ?>
				    </ul>
		        </div>
		        <?php if($current_page > 1):?>
		        <div class="category_series_b">
			        <ul>
					    <li>
					    	<a <?php if(!empty($prev_link)){echo 'href="'.$prev_link.'"';}?>   class="fa fa-angle-left"></a>
					    </li>
					    <li>
					    	<?php echo $current_page;?>
					    </li>
					    <li>
					    	<a  <?php if(!empty($next_link)){echo 'href="'.$next_link.'"';}?>  class="fa fa-angle-right"></a>
					    </li>
				    </ul>
		        </div>
			    <?php endif ?>
			    
		    </div>
	    </div>
    </div>
</div>
