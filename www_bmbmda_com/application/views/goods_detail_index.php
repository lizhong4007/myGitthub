<div class="main" >
	<div class="goods_detail">
		<div class="goods_detail_nav">
			<ul>
				<li class="goods_detail_nav_brand">
					<a href="<?php echo site_url('brand/brand_detail/'.$brand['brandid'].'/'.$brand['linkurl']);?>" title="<?php echo $brand['brand_alias'];?>">
						<img src="<?php echo $site['image_domain'].$brand['thumb'];?>" />
					</a>
				</li>
				<?php if(!empty($category)): ?>
					<li>
						<a href="<?php echo site_url('category/category_detail/'.$category['catid'].'/'.$category['linkurl']);?>" title="<?php echo $category['cat_alias'];?>">
							<?php echo $category['cat_alias'];?>
							 <i>></i>
						</a>
					</li>
				<?php endif ?>
				<?php if(!empty($series)): ?>
					<li>
						<a href="<?php echo site_url('series/series_detail/'.$series['seriesid'].'/'.$series['linkurl']);?>" title="<?php echo $series['series_alias'];?>">
							<?php echo $series['series_alias'];?>
						</a>
					</li>
				<?php endif ?>

			</ul>
		</div>
		<div class="goods_detail_title">
		    <h2><?php echo $goods['model'];?></h2>
		</div>
		<div class="goods_detail_body">
			<div class="" >
                <div  class=" slideBox">
                    <div class="goods_detail_dot hd">
                        <ul>
                            <li>Information</li>
                            <?php if(!empty($series_content)):?>
	                            <li>Description</li>
	                        <?php endif ?>
	                        <?php if(!empty($resource)  or !empty($series_thread)):?>
	                            <li>Resource</li>
	                        <?php endif ?>
	                        <?php if(!empty($manual)):?>
	                            <li>Manual</li>
	                        <?php endif ?>
	                        <?php if(!empty($company)):?>
		                        <li>
			                        Distributor
		                        </li>
	                        <?php endif ?>
                        </ul>
                        <div class="clear"></div>
                    </div>
                    <div class="bd slider goods_detail_slide">
                        <div class="goods_detail_prev">
	                        <a class="prev" href="javascript:void(0)">
		                        <img src="<?php echo base_url('public/home/images/left_arrow.png');?>" />
	                        </a>
                        </div>
                        <div class="goods_detail_image">
	                        <ul>
	                            <li class="goods_detail_image_item">
	                                <div class="goods_detail_image_item_l">
		                                <img class="lazy"  src="<?php echo $site['image_default'];?>" data-original="<?php echo $site['image_domain'].$goods['thumb'];?>" alt="<?php echo $goods['en_title'];?>" />
	                                </div>
	                                <div class="goods_detail_image_item_r">
	                                    <div class="goods_detail_image_item_title">
		                                    <span class="goods_detail_item_title">
			                                    <?php echo $goods['en_title'];?>
		                                    </span>
		                                    <span class="goods_detail_item_price">
		                                        <?php if(strcmp(strval($goods['min_price']), '0.00') == 0):?>
		                                        	<?php echo $goods['currency'];?>&nbsp;-
		                                        <?php else:?>
		                                    	<?php echo $goods['currency'].$goods['min_price'];?>
			                                    <?php endif ?>
		                                    </span>
	                                    </div>
		                                <ol>
		                                    <?php if(count($param) < 5):?>
				                                <li>
					                                <span>model:</span>
					                                <?php echo $goods['model'];?>
				                                </li>
				                                <li>
					                               <span>brand:</span>
					                               <?php echo $goods['en_brand'];?>
				                                </li>
				                            <?php endif ?>
				                            <?php foreach($param as $key=>$value):?>
			                                <li>
				                                <span>
					                                <?php echo $value['param_alias'];?>:
				                                </span>
				                                <?php echo $value['value'];?>
			                                </li>
				                            <?php endforeach ?>
		                                </ol>
	                                </div>
	                            </li>
	                            <?php if(!empty($series_content['content'])):?>
		                            <li class="goods_detail_image_item on">
		                                <div class="goods_detail_image_con_title">
		                                	<?php echo $goods['en_title'];?>
		                                </div>
		                                <div class="goods_detail_image_content">
					                        <?php echo $series_content['content']; ?>
		                                </div>
		                            </li>
				                <?php endif ?>

				                <?php if(!empty($resource) or !empty($series_thread)):?>
	                            <li class="goods_detail_image_resource">
	                                <div class="model_resource">
	                                    <?php if((count($resource)+count($series_thread)) > 1 ):?>
			                                <div class="goods_detail_resource_b">
				                                <a class="prevx fl" href="javascript:void(0)">Previous</a>
				                                <a class="nextx fr" href="javascript:void(0)">Next</a>
			                                </div>
			                            <?php endif ?>
		                                <div class="bd goods_detail_resource_t">
			                                <ol>
			                                    <?php foreach($resource as $value):?>
					                                <li>
						                                <a href="<?php echo $site['image_domain'].$value;?>" target="_blank" rel="nofollow">
							                                <img class="img-responsive" src="<?php echo $site['image_domain'].$value;?>" alt="<?php echo $goods['en_title'];?>" />
						                                </a>
					                                </li>
					                            <?php endforeach ?>
					                            <?php foreach($series_thread as $value):?>
					                                <li>
						                                <a href="<?php echo $site['image_domain'].$value['local_thumb'];?>" target="_blank" rel="nofollow">
							                                <img class="img-responsive"  src="<?php echo $site['image_domain'].$value['local_thumb'];?>" alt="<?php if(!empty($value['title'])){echo $value['title'];}else{
							                                	echo $goods['en_title'];
							                                	} ?>" />
						                                </a>
					                                </li>
					                            <?php endforeach ?>
				                            </ol>
		                                </div>
	                                </div>
	                            </li>
	                            <?php endif ?>

	                            <?php if(!empty($manual)):?>
		                            <li class="goods_detail_manual">
		                                <ol>
		                                    <?php foreach($manual as $value):?>
		                                    <li>
			                                    <a href="<?php echo $site['image_domain'].$value['resource'];?>" target="_blank" title="<?php echo $value['res_name'];?>">
			                                       <?php echo $value['res_name'];?>
			                                    </a>
		                                    </li>
		                                    <?php endforeach ?>
		                                </ol>
		                            </li>
	                            <?php endif ?>
	                            <?php if(!empty($company)):?>
									<div class="company">
									    <div class="company_title">
									        Distributor
									    </div>
									    <div class="company_body">
									        <table>
										        <tr>
											        <th>company</th>
											        <th>model</th>
											        <th>price</th>
											        <th>shop</th>
										        </tr>
										        <?php foreach($company as $value):?>
										        <tr>
											        <td><?php echo $value['company_alias'];?></td>
											        <td><?php echo $goods['model'];?></td>
											        <td><?php echo $goods['min_price'];?></td>
											        <td>
												        <a href="<?php echo $value['site'];?>" rel="nofollow">
												           Visit shop	
												        </a>
											        </td>
										        </tr>
										        <?php endforeach ?>
									        </table>
									    </div>
									</div>
								<?php endif ?>
	                        </ul>
                        </div>
                        <!-- arrow -->
	                    <div class="goods_detail_next">
                            <a class="next" href="javascript:void(0)">
	                            <img src="<?php echo base_url('public/home/images/right_arrow.png');?>" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>

