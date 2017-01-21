<?php
namespace TyreWWW\Controller;
use Think\Controller;
class TableController extends Controller {

	function index()
	{

		/*$M_goods = M("series");//更改系列状态，如果系列下存在型号，更改状态为1
		$model = M('model');
		$g_data = $M_goods->where(array('status'=>0))->select();
		foreach ($g_data as $key => $value) {
			$tmp = array();
			$model_tmp = array();
			$model_tmp = $model->where(array('seriesid'=>$value['seriesid']))->find();
			if(!empty($model_tmp))
			{
				$M_goods->where(array('seriesid'=>$value['seriesid']))->save(array('status'=>1));
			}
		}*/
		// print_r($g_data);
		
		//处理产品
		/*$M_goods = M('goods_value');

		$g_data = $M_goods->where(array('paraid=20'))->select();
		foreach ($g_data as $key => $value) {
			$value_tmp1 = '';
			$value_tmp2 = '';
			$value_tmp1 = preg_replace('/[^0-9\.]/', '', $value['value']);
			$value_tmp2 = preg_replace('/[^a-zA-Z]/', '', $value['value']);
			$value_tmp2 = substr($value_tmp2, 0,1);
				$M_goods->where(array('vid'=>$value['vid']))->save(array('value'=>$value_tmp1.$value_tmp2));
			
			
			// 
			
		}*/

		/*$M_goods = M('goods');

		$g_data = $M_goods->where(array('brandid=7'))->select();
		foreach ($g_data as $key => $value) {
			$value_tmp1 = '';
			$brand = array();
			$category = array();
			$brand = M('brand')->where(array('brandid'=>7))->find();
			$category = M('category')->where(array('catid'=>$value['catid']))->find();
			$title_str = '';
			$en_title_str = '';
			$title_str = $brand['brand_name'].' '.$category['cat_name'].' '.$value['model'];
			$en_title_str = $brand['brand_alias'].' '.$category['cat_alias'].' '.$value['model'];
			$linkurl = '';
			$linkurl = preg_replace('/[^0-9a-zA-Z]/', '-', $title_str);
			$linkurl = preg_replace('/(-)+/', '-', $linkurl);
			$M_goods->where(array('goodsid'=>$value['goodsid']))->save(array('title'=>$title_str,'en_title'=>$en_title_str,'linkurl'=>$linkurl));
			
			
			// 
			
		}

		
		print_r($g_data);*/

		/*$M_goods = M('category');

		$g_data = $M_goods->select();
		foreach ($g_data as $key => $value) {
			$linkurl = '';
			$linkurl = preg_replace('/[^0-9a-zA-Z]/', '-', $value['cat_alias']);
			$linkurl = preg_replace('/(-)+/', '-', $linkurl);
			
			$M_goods->where(array('catid'=>$value['catid']))->save(array('linkurl'=>$linkurl));
			
			
			// 
			
		}*/


	}
}