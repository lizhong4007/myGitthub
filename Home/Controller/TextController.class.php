<?php
namespace Home\Controller;
use Think\Controller;
class TextController extends Controller {
	public function index()
	{
		$model_name = I('model','');
		$series = ;
		$this->assign('series',$series);
        //型号
		$model = M('model')->where(array('model_name'=>$model_name))->select();
		$this->assign('model',$model);
        
        $seriesid_arr = array();
		foreach ($model as $key => $value) {
			$seriesid_arr[] = $value['seriesid'];
		}

		//型号参数
		$modelid = array();
		foreach ($model as $key => $value) {
			$modelid[] = $value['modelid'];
		}
		$model_para = M('model_spec')->where(array('modelid'=>array('in',$modelid)))->select();
		$this->assign('model_para',$model_para);

		//系列
		$series = M('series')->where(array('seriesid'=>array('in',$seriesid_arr)))->select();
		$this->assign('series',$series);

		//商品
		$goods = M('goods')->where(array('modelid'=>array('in',$modelid)))->select();
		$this->assign('goods',$goods);

		//商品规格
		$goodsid = array();
		foreach ($goods as $key => $value) {
			$goodsid[] = $value['goodsid'];
		}

		//goods_value
		$goods_value = M('goods')->where(array('goodsid'=>array('in',$goodsid)))->select();
		
		$paraid = array();
		foreach ($goods_value as $key => $value) {
			$paraid[] = $value['paraid'];
		}

		//goods_param 表
		$goods_param = M('goods_param')->where(array('paraid'=>array('in',$paraid)))->select();
		
		$category_option_para = array();
		foreach ($goods_value as $key => $value) {
			foreach ($goods_param as $k => $v) {
				if($value['paraid'] == $v['paraid'])
				{
					$category_option_para[] = array_merge($value,$v);
				}
			}
		}

		$this->assign('category_option_para',$category_option_para);
		//商品规格结束
		
		 //资源表
		$resids = array();
		foreach ($model as $key => $value) {
			$resids[] = $value['resids'];
		}
		$resids_str = implode(',',$resids);
		$resids_arr = explode(',',$resids_str);

		//resource 表
		$residsData = M('resource')->where(array('resid'=>array('in',$resids_arr)))->select();
		$this->assign('residsData',$residsData);

		$this->display('Text');

	}
}