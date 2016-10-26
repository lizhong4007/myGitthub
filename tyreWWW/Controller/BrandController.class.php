<?php
namespace TyreWWW\Controller;
use Think\Controller;
class BrandController extends Controller {

	/*商品列表*/
	public function brand_list(){

		$brandid = (int)I('brandid','');
		//品牌
		$brand = D("Brand")->getBrand($brandid);
		$this->assign("brand",$brand);
		//系列
		$series = D("Series")->getSeriesData(array('brandid'=>$brandid));
		$catids = array();
		foreach ($series as $key => $value) {
			$catids[] = $value['catid'];
		}
		//分类
		$catids = array_unique($catids);
		$category = D('Category')->getCategoryList();
		$this->assign("category",$category);
		$this->assign("catids",$catids);
		// 赛选条件
		$where = array();
		$catid = (int)I('get.catid','');
		if(!empty($catid))
		{
			$where['catid'] = $catid;
			$this->assign("catid",$catid);
		}
		$p = (int)I('p',1);
		$where['brandid'] = $brandid;
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
		$this->assign("goods",$goods_data_tmp);
		$this->assign("page",$goodslist['page']);

		$this->display("Brand/List");
	}
}