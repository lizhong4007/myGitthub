<?php
namespace tyreWWW\Controller;
use Think\Controller;
class HomeController extends CommonController {
	public function index()
	{
		//分类
		$category = D('Category')->getCategoryList();
		$this->assign("category",$category);
		// 商品
		$where = array();
		$p = (int)I('p',1);
		$size = 20;
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

		// print_r($goods_data_tmp);exit;
		$this->display("Home/Index");
		// $this->display("Goods/List");
		// $this->display("Goods/Detail");

	}

}