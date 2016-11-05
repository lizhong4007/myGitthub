<?php
namespace TyreWWW\Controller;
use Think\Controller;
class HomePageController extends CommonController {
	public function index()
	{
		//分类
		$category = D('Category')->getCategoryList();
		$this->assign("category",$category);
		// 商品
		$where = array();
		$p = (int)I('p',1);
		$size = 64;
		
		$is_imporat = (int)I('ip','');
		if(!empty($is_imporat))
		{
			$where['is_import'] = $is_imporat;
		}
		$this->assign("ip",$is_imporat);

		$goodslist = D("Goods")->getGoodsList($where,$p,$size);
		$goods_data = $goodslist['data'];

		//实例化商品参数
		$S_GoodsParam = D("GoodsParam","Service");
		$goods_data_tmp = array();
		foreach ($goods_data as $key => $value) {
			$tmp = array();
			$tmp = $S_GoodsParam->getGoodsParameter($value['goodsid']);
			$value['param'] = $tmp;
			$goods_data_tmp[] = $value;
		}
		$this->assign("goods_data",$goods_data_tmp);
		$this->assign("page",$goodslist['page']);

		//推荐
		$recommed_goods = D("Goods")->getGoodsList($where,5,8);
		$this->assign("recommed_goods",$recommed_goods['data']);

		$this->display("HomePage/home_list");

	}

}