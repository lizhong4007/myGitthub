<div class="header_blank"></div>
  <div class="main">
    <div class="width100 main_nav fl">
      <ul>
        <li>
          <a href="<?php echo site_url('brand/brand_detail/'.$brand['brandid'].'/'.$brand['linkurl']);?>" title="<?php echo $brand['brand_alias'];?>">
            <?php echo $brand['brand_alias'];?>
          </a>
        </li>
        <li>
          <a href="<?php echo site_url('category/category_detail/'.$category['catid'].'/'.$category['linkurl']);?>" title="<?php echo $category['cat_alias'];?>">
            <?php echo $category['cat_alias'];?>
          </a>
        </li>
      </ul>
      <div class="clear"></div>
    </div>
    <div class="width100 seires_curr"><?php echo $series['series_alias'];?></div>
    <div class="sg_line"></div>
    <!-- images -->
    <div class="width100 -fl seires_img" id="slide_box">
      <div id="slideBox" class=" slideBox">
        <div class="slide_dot hd">
          <ul>
            <!-- <li>1</li> -->
            <!-- <li>2</li>
            <li>3</li> --></ul>
        </div>
        <div class="bd slider">
          <ul>
            <?php foreach($thumb as $key=>$value):?>
            <li>
              <img class="lazy"  src="<?php echo $site['image_default'];?>" data-original="<?php echo $site['image_domain'].$value;?>" alt="<?php echo $series['series_alias'];?>" title="<?php echo $series['series_alias'].'_'.$key;?>" />
            </li>
            <?php endforeach ?>
          </ul>
            <if condition="count($thumb) gt '1'">
            <?php if(count($thumb)>1):?>
              <!-- arrow -->
              <a class="prev fa fa-angle-left" href="javascript:void(0)"></a>
              <a class="next fa fa-angle-right" href="javascript:void(0)"></a>
            <?php endif ?>
          </div>
      </div>
      </div>
      <div class="clear"></div>
    </div>
    <?php if(!empty($series_content)):?>
    <!-- content -->
      <div class="sg_line"></div>
      <div class="series_content">
        <?php echo $series_content['content'];?>
      </div>
    <?php endif ?>
    
    <?php if(!empty($goods)):?>
    <!-- goods -->
    <div class="sg_line"></div>
    <div class="series_goods">
      <div class="series_goods_title">
        <b>Model</b>
      </div>
      <div class="series_goods_body">
          <ul>
            <?php foreach($goods as $key=>$value):?>
              <li>
                <a href="<?php echo site_url('goods/goods_detail/'.$value['goodsid'].'/'.$value['linkurl']);?>" title="<?php echo $value['model'];?>"><?php echo $value['model'];?></a>
              </li>
            <?php endforeach ?>
          </ul>
        <div class="clear"></div>
      </div>

      <?php if($current_page > 1):?>
      <div class="series_goods_page">
        <ul>
            <li>
              <a href="<?php echo $prev_link;?>"   class="fa fa-angle-left"></a>
            </li>
            <li>
              <?php echo $current_page;?>
            </li>
            <li>
              <a href="<?php echo $next_link;?>"   class="fa fa-angle-right"></a>
            </li>
        </ul>
        <div class="clear"></div>

      </div>
    <?php endif ?>
    </div>
    <?php endif ?>

     <?php if(!empty($company)):?>
    <!-- company -->
    <div class="sg_line"></div>
    <div class="series_company">
      <div class="series_company_title">
        <b>Distributor</b>
      </div>
      <div class="series_company_body">
        <ul>
          <?php foreach($company as $key=>$value):?>
          <li>
            <div class="series_company_name"><?php echo $value['company_alias'] ;?></div>
            <?php if(!empty($value['distributor']['telephone'])):?>
            <div class="series_company_phone">
              <i class="fa fa-phone"></i>
              <?php echo $value['distributor']['telephone'];?>
            </div>
            <?php endif ?>
            <?php if(!empty($value['distributor']['address_alias'])):?>
            <div class="series_company_address">
              <i class="fa fa-map-marker"></i>
              <?php echo $value['distributor']['address_alias'];?>
            </div>
            <?php endif ?>
            <div class="series_company_contact">
              <a href="<?php echo $value['site'];?>" target="_blank" rel="nofollow">Official</a></div>
          </li>
          <?php endforeach ?>
        </ul>
      </div>
    </div>
    <?php endif ?>
    
    <?php if(count($recommend_series) > 1):?>
      <!-- recommend -->
      <div class="sg_line"></div>
      <div class="series_recommend">
        <div class="series_recommend_title">
          <b>Related Thread</b>
        </div>
        <div class="series_recommend_body">
            <ul>
              <?php foreach($recommend_series as $key=>$value):?>
                <?php if($series['seriesid'] != $value['seriesid']):?>
                  <li>
                    <a href="<?php echo site_url('series/series_detail/'.$value['seriesid'].'/'.$value['linkurl']);?>">
                      <?php echo $value['series_alias'];?>
                    </a>
                  </li>
                <?php endif ?>
              <?php endforeach ?>
            </ul>
            <div class="clear"></div>
        </div>
      </div>
    <?php endif ?>
  </div>

