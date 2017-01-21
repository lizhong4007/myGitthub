<div class="header_blank"></div>
    <?php  if(!empty($goods)):?>
    <div class="main">
        <div class="search_main">
            <div class=" search_t">
                <h2><?php echo $keywords;?></h2>
            </div>
            <div class=" search_b">
                <div class=" search_b_content">
                    <ul>
                        <?php foreach($goods as $value):?>
                        <li>
                            <a href="<?php echo site_url('goods/goods_detail/'.$value['goodsid'].'/'.$value['linkurl']);?>">
                            <div class=" search_b_content_img">
                                <img class="lazy"  src="<?php echo $site['image_default'];?>" data-original="<?php echo $site['image_domain'].$value['thumb'];?>" alt="<?php echo $value['en_title'];?>" title="<?php echo $value['en_title'];?>" />
                            </div>
                            <div class=" search_b_content_title">
                                <?php echo $value['en_title'];?>
                            </div>
                            </a>
                        </li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <?php if($total_page > 1):?>
                    <div class=" search_b_page">
                        <div class=" search_b_page_con">
                            <ul>
                                <li>
                                    <a <?php if($total_page > 1){echo 'href="'.$prev_link.'"';}?> class="fa fa-angle-left"></a>
                                </li>
                                <li>
                                    <a >
                                        <em><?php echo $current_page;?></em>/<?php echo $total_page;?>
                                    </a>
                                </li>
                                <li>
                                   <a <?php if($total_page > 1){echo 'href="'.$next_link.'"';}?>  class="fa fa-angle-right"></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php endif ?>
                   
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="search_nothing">
            <div>Sorry! can not find the<em><?php echo $keywords;?></em> </div>
            <div><a id="search_nothing">Try another again!</a></div>
    </div>
    <?php endif ?>

