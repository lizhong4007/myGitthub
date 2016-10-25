<?php
namespace tyreWWW\Controller;
use Think\Controller;
class GoodsController extends CommonController {

	/*商品列表*/
	public function goods_list(){
		$catid = (int)I('catid','');
		//分类
		$M_Category = D('Category');
		$catids = array();
		$sub_category = $M_Category->getCategoryByParentid($catid);
		foreach ($sub_category as $key => $value) {
			$catids[] = $value['catid'];
		}
		$catids[] = $catid;
		$category = $M_Category->getCategoryList();
		$current_category = $category[$catid];
		$parent_category = $category[$current_category['parentid']];
		$this->assign("current_category",$current_category);
		$this->assign("parent_category",$parent_category);
		//系列
		$series = D("Series")->getSeriesData(array('catid'=>array('in',$catids)));
		$this->assign("series",$series);
		/*// print_r($series);exit();

		//品牌
		$brand = array();
		$brand_data = array();
		$M_brand = D('Brand');
		foreach ($series as $key => $value) {
			$tmp = '';
			$tmp = $M_brand ->getBrand($value['brandid']);
			$value['brand'] = $tmp;
			$brand[] = $tmp;
			$brand_data[] = $value;
		}
		$brand = array_unique($brand);
		$this->assign("brand",$brand);*/

		//品牌
		$brand = array();
        $brandids = array();
		foreach ($series as $key => $value) {
			$brandids[] = $value['brandid'];
		}
		$brandids = array_unique($brandids);
		$M_brand = D('Brand');
		if(!empty($brandids))
		{
		   $brand = $M_brand->getBrandData(array('brandid'=>array('in',$brandids)));
		}
		$this->assign("brand",$brand);
		// 商品
		$where = array();
		//筛选条件
		$this->assign("catid",$catid);
		$seriesid = (int)I('seriesid','');
		if(!empty($seriesid))
		{
			$where['seriesid'] = $seriesid;
		}
		$p = (int)I('p',1);
		$size = 20;
		$where['catid'] = array('in',$catids);
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
		// print_r($brand);exit;

		$this->display("Goods/List");
	}
	
	/*商品详细页*/
	public function detail()
	{
		$goodsid = I('goodsid','');
		$M_goods = D('Goods');
		$goods = $M_goods->getGoods($goodsid);
		$this->assign("goods",$goods);
		//分类
		$category = D('Category')->getCategoryList();
		$current_category = $category[$goods['catid']];
		$parent_category = $category[$current_category['parentid']];
		$this->assign("current_category",$current_category);
		$this->assign("parent_category",$parent_category);
		//系列
		$M_series = D("Series");
		$nav_series = $M_series->getSeries($goods['seriesid']);
		$this->assign("nav_series",$nav_series);
		//花纹
		$series_resource = $M_series->getSeriesResource($goods['seriesid']);
		$this->assign("series_resource",$series_resource);
		//系列内容
		$series_content = $M_series->getSeriesContent($goods['seriesid']);
		$this->assign("series_content",$series_content);
		//型号
		$nav_model = array("model"=>$goods['model']);
		$this->assign("nav_model",$nav_model);
		//参数
		$S_GoodsParam = D("GoodsParam","Service");
		$param = $S_GoodsParam->getGoodsParameter($goods['goodsid']);
		$this->assign("param",$param);
		//型号可替换尺寸
		$model_replace = D('ModelReplace')->getModelbyModelid($goods['modelid']);
		$this->assign("model_replace",$model_replace);
		//品牌
		$recommend_brand = D('Brand')->getBrandData(array('is_recommend<>0'));
		$this->assign("recommend_brand",$recommend_brand);
		//company
		$relative_goods = $M_goods->getGoodsData(array("modelid"=>$goods['modelid']));
		$M_company = D("Company");
		$M_goods_content = D("GoodsContent");
		$companyids = array();
		$distributor = array();
		foreach ($relative_goods as $key => $value) {
			$companyids[] = $value['companyid'];
			$value['site'] = $source_site;
			$source_site = '';//官网
			$source_site = $M_goods_content->getGoodsContent($value['goodsid']);
			$value['site'] = $source_site;
			$distributor[$value['companyid']] = $value;
		}
		$company = array();
		$companyids = array_unique($companyids);
		$company = $M_company->getCompanyData(array('companyid'=>array('in',$companyids)));
		$this->assign("company",$company);
		$this->assign("distributor",$distributor);

		// print_r($series_resource);exit;
		$this->display("Goods/Detail");
	}


}