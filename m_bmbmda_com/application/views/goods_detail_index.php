<div class="header_blank"></div>
<div class="main">
  <div -class="goods_detail">
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
    <div class="width100 seires_img" id="slide_box">
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
              <img class="lazy"  src="<?php echo $site['image_default'];?>" data-original="<?php echo $site['image_domain'].$value;?>" alt="bmbmda.com" title="<?php echo $goods['model'].'_'.$key;?>" />
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
      <div class="clear"></div>
    </div>
    <?php if(!empty($series_content)):?>
    <!-- content -->
      <div class="sg_line"></div>
      <div class="series_content">
        <?php echo $series_content['content'];?>
      </div>
    <?php endif ?>
    <!-- goods spec -->
    <div class="sg_line"></div>
    <div class="goods_detail_spec">
      <div class="goods_detail_spec_title">
        <b>Specifications</b>
      </div>
      <div class="goods_detail_spec_body">
        <ul>
          <?php if(count($param) < 5):?>
            <li>
              <span>brand:</span><?php echo $brand['brand_alias'];?>
            </li>
            <li>
              <span>thread:</span><?php echo $series['series_alias'];?>
            </li>
            <li>
              <span>model:</span><?php echo $goods['model'];?>
            </li>
          <?php endif ?>
          <?php foreach($param as $key=>$value):?>
            <li>
              <span><?php echo $value['param_alias'];?>:</span><?php echo $value['value'];?>
            </li>
          <?php endforeach ?>
         </ul>
        <div class="clear"></div>
      </div>
    </div>
    
  <?php if(!empty($resource)):?>
  <!-- resource -->
    <div class="sg_line"></div>
    <div class="width100 model_resource" id="model_resource_box">
        <div class="model_resource_title">
          <b>Resource</b>
        </div>
        <div id="modelresourceBox" class=" modelresourceBox slideBox">
            <div class="slide_dot hd">
                <ul>
                    <!-- <li>1</li> -->
                    <!-- <li>2</li>
                    <li>3</li> -->
                </ul>
            </div>
            <div class="bd slider">
                <ul>
                    <?php foreach($resource as $key=>$value):?>
                      <li>
                        <img  class="img-responsive" src="<?php echo  $site['image_domain'].$value;?>" alt="<?php echo $goods['en_title'];?>" title="<?php echo $goods['en_title'];?>" />
                          <a href="<?php echo  $site['image_domain'].$value;?>" class="src_large fa fa-search " rel="nofollow" title="large" target="_blank"></a>
                      </li>
                    <?php endforeach ?>
                    
                </ul>

                <?php if(count($resource)>1):?>
                  <!-- arrow -->
                  <a class="prev fa fa-angle-left" href="javascript:void(0)"></a>
                  <a class="next fa fa-angle-right" href="javascript:void(0)"></a>
                <?php endif ?>
              
            </div>
            
        </div>
        <div class="clear"></div>
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

    <?php if(count($recommend_model) > 1):?>
      <!-- recommend -->
      <div class="sg_line"></div>
      <div class="series_recommend">
        <div class="series_recommend_title">
          <b>Related model</b>
        </div>
        <div class="series_recommend_body">
            <ul>
              <?php foreach($recommend_model as $key=>$value):?>
                <?php if($goods['goodsid'] != $value['goodsid']):?>
                  <li>
                    <a href="<?php echo site_url('goods/goods_detail/'.$value['goodsid'].'/'.$value['linkurl']);?>">
                      <?php echo $value['model'];?>
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
</div>

