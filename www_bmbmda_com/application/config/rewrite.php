<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['pattern'] = array();
$config['replace'] = array();


$config['pattern'][0] = '/brand\/brand_detail/isU';
$config['replace'][0] = '/brand';


$config['pattern'][1] = '/category\/category_detail/isU';
$config['replace'][1] = '/category';

$config['pattern'][2] = '/goods\/goods_detail/isU';
$config['replace'][2] = '/goods';

/*$config['pattern'][3] = '/search\/search_detail/isU';
$config['replace'][3] = '/searcher';*/

$config['pattern'][4] = '/series\/series_detail/isU';
$config['replace'][4] = '/series';


