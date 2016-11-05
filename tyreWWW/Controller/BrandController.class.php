<?php
namespace TyreWWW\Controller;
use Think\Controller;
class BrandController extends CommonController {

	/*商品列表*/
	public function brand_list(){
        
        $brand = array();
		//品牌
		$brand = D("Brands")->getAllBrand(array('is_recommend'=>1));
        
        $brand_data = array();
        $M_series = D('Series');
		foreach ($brand as $key => $value) {
			$tmp = array();
			$tmp = $M_series->getSeriesData(array('brandid'=>$value['brandid']),1);
			$value['series'] = array_pop($tmp);
			$brand_data[] = $value;
		}
		$this->assign("brand",$brand_data);

		/*$brandids = array();
		foreach ($brand as $key => $value) {
			$brandids[] = $value['brandid'];
		}
		
		$p = (int)I('p',1);
		$where['brandid'] = array('in',$brandids);
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
		$this->assign("page",$goodslist['page']);*/

		$this->display("Brand/brand_list");
	}
}