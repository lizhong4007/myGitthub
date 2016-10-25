<?php
namespace tyreWWW\Controller;
use Think\Controller;
class SeriesController extends CommonController {

	/*商品系列 列表*/
	public function series_list(){
		// 系列
		$seriesid = I('seriesid','');
		$M_series = D("Series");
		$nav_series = $M_series->getSeries($seriesid);
		$this->assign("nav_series",$nav_series);
		//分类
		$category = D('Category')->getCategoryList();
		$current_category = $category[$nav_series['catid']];
		$parent_category = $category[$current_category['parentid']];
		$this->assign("current_category",$current_category);
		$this->assign("parent_category",$parent_category);
		//品牌
		$brand = D('Brand')->getBrand($nav_series['brandid']);
		$this->assign("brand",$brand);
		// print_r($nav_series);exit;
        // 商品
		$where = array();
		$p = (int)I('p',1);
		$size = 20;
		$where['seriesid'] = $seriesid;
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

		$this->display("Series/seriesList");
	}
	
	/*根据分类和品牌查询系列*/
	public function get_series()
	{
		$catid = (int)I('cat_id','');
		$brandid = (int)I('brand_id','');
		$M_series = D('Series');
		//分类
		$M_Category = D('Category');
		$catids = array();
		$sub_category = $M_Category->getCategoryByParentid($catid);
		foreach ($sub_category as $key => $value) {
			$catids[] = $value['catid'];
		}
		$catids[] = $catid;
		$series = $M_series->getSeriesData(array('catid'=>array('in',$catids),'brandid'=>$brandid));
		if($series)
		{
			echo json_encode(array('code'=>1,'message'=>$series));
			die;
		}else{
			echo json_encode(array('code'=>0));
			die;
		}
	}

}