<?php
namespace TyreWWW\Controller;
use Think\Controller;
class EggController extends CommonController {

	/*商品列表*/
	public function index(){

	    $data = M('goods_value')->field("*,count(*) as total")->group('value')->order("total desc")->select();;
	    echo M('goods_value')->_sql();
	    $t_param = M('goods_param');
	    $param = array();
	    $param_1 = array();//帘布层评级
	    foreach ($data as $key => $value) {
	    	$tmp = array();
	    	$tmp = $t_param->where(array('paraid'=>$value['paraid']))->find();
	    	$value['param'] = $tmp['param'];
	    	if($value['paraid'] == 18)
	    	{
	    		$param_1[] = array('value'=>$value['value']);
	    	}
	    	

	    	$param[] = $value;

	    }
	    print_r($param_1);

		
	}
}