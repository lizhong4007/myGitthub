<!DOCTYPE html>
<html>
  <head lang="en">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="content-language" content="en-us" />
    <?php echo $seo;?>
    <link rel="shortcut icon" type="image/x-icon" href="__STATIC__/images/favicon.ico" />
    <!-- Bootstrap 3.3.5 -->
    <link type="text/css" href="<?php echo base_url('public/font-awesome-4.7.0/css/font-awesome.min.css');?>" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url('public/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url('public/home/css/common.min.css');?>" rel="stylesheet">
    <link type="text/css" href="<?php echo base_url('public/home/css/goods_detail.min.css');?>" rel="stylesheet">
    
  </head>
  <body>
    <div class="header">
      <div class="header_title col-xs-12 row padding_0">
        <div class="header_title_l col-xs-4 fl row ">
          <i class="fa fa-reorder nav_icon"></i>
        </div>
        <div class="header_title_c col-xs-4">
          <a href="/"><img src="<?php echo base_url('public/home/images/header_logo.png');?>" title="bmbmda.com" alt="bmbmda" /></a></div>
        <div class="header_title_r col-xs-4 row ">
          <i class="fa fa-search btn_search"></i>
        </div>
      </div>
      <div class="nav">
        <input value="0" id="nav_status" type="hidden">
        <ul>
          <li>
            <a href="/">
              <i class="fa fa-home"></i>Home
            </a>
          </li>
          <li>
            <a href="<?php echo site_url('category/category_detail/13/passenger');?>" title="Passenger">
              <i class="fa fa-angle-right"></i>Passenger</a>
          </li>
          <li>
            <a href="<?php echo site_url('category/category_detail/3/suv');?>" title="SUV">
              <i class="fa fa-angle-right"></i>SUV</a>
          </li>
          <li>
            <a href="#" rel="nofollow">
              <i class="fa fa-angle-right"></i>About US</a>
          </li>
          <li>
            <a href="#" rel="nofollow">
              <i class="fa fa-angle-right"></i>Contacts</a>
          </li>
        </ul>
      </div>
      <div class="search_nav col-xs-12" style="display: none;">
        <form action="<?php echo site_url('search/search_detail');?>" method="post" id="search_form">
          <div class="search_div ">
            <input class="" name="keywords">
            <i class="fa fa-search" id="search_goods"></i>
          </div>
        </form>
      </div>
    </div>