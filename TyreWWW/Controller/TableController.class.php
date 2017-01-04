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
		$M_goods = M('goods_value');

		$g_data = $M_goods->where(array('paraid=21'))->select();
		foreach ($g_data as $key => $value) {
			$value_tmp = array();
			$value_tmp = explode('/',$value['value']);
			if($value_tmp[0] == $value_tmp[1])
			{
				$M_goods->where(array('vid'=>$value['vid']))->save(array('value'=>$value_tmp[0]));
			}
			
			
			// 
			
		}
		print_r($g_data);


	}
}