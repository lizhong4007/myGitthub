<?php
namespace TyreMobile\Controller;
use Think\Controller;
class GoodsController extends CommonController {
	public function goods_list()
	{
		$catid = intval(I('catid',''));
		$brandid = intval(I('brandid',''));
		$M_category = D('Category');
		$category = array();
		$category = $M_category->getCategory($catid);
		
		//brand
		$M_brand = D('Brand');
		$brand = array();
		$brand = $M_brand->getBrand($brandid);
		if(empty($category) and empty($brand))
		{
			$this->display("public:404");
			die;
		}
		$this->assign('brand',$brand);
		$this->assign('category',$category);

		//goods
		$M_goods = D('Goods');
		$goods = array();
		$p = intval(I('p',1));
		$where = array();
		if(!empty($catid))
		{
			$category_child = array();
			$category_child = D('Category')->getCategoryData(array('parentid'=>$catid));
			$catids = array();
			$catids[] = $catid; 
			foreach ($category_child as $key => $value) {
				$catids[] = $value['catid'];
			}
			$where['catid'] = array('in',$catids);
		}

		if(!empty($brandid))
		{
			$where['brandid'] = $brandid;
		}

		$goods = $M_goods->getGoodsList($where,$p,12);
		
		$this->assign('goods',$goods);

		$this->assign('current_page',$p);

		/*seo*/
		$seo = '<title>型号 '.$category['cat_name'].' '.$brand['brand_name'].'-蹦蹦哒</title>';
		$seo .= '<meta name="description" content="'.$category['cat_name'].' '.$brand['brand_name'].' 蹦蹦哒" />';
		$seo .= '<meta name="keywords" content=" 型号 经销商 花纹 '.$category['cat_name'].' '.$brand['brand_name'].'" />';
		if(!empty($catid))
		{
			$seo .= '<link rel="canonical" href="'.$this->default_site.U('Goods/goods_list',array('catid'=>$catid,'p'=>$p)).'" />';
		}

		if(!empty($brandid))
		{
			$seo .= '<link rel="canonical" href="'.$this->default_site.U('Brand/brand_list',array('brandid'=>$brandid)).'" />';
		}
		
		$this->assign("seo",$seo);

		$this->display("Goods/goods_list");

	}
	public function detail()
	{
		$goodsid = intval(I('goodsid',''));
		$M_goods = D('Goods');
		$goods = array();
		$goods = $M_goods->getGoods($goodsid);
		if(empty($goods))
		{
			$this->display("Public:404");
			die;
		}
		$this->assign('goods',$goods);

		//处理图片
		$thumb = array();
		if(empty($goods['thumb']))
		{
			$default_image = '';
			$default_image = $this->default_image;
			$default_image = str_replace($this->site_imagedomain, '', $default_image);
			$thumb[] = $default_image;
		}else{
			$thumb[] = $goods['thumb'];
		}

		if(!empty($goods['thumb2']))
		{
			$thumb[] = $goods['thumb2'];
		}

		if(!empty($goods['thumb3']))
		{
			$thumb[] = $goods['thumb3'];
		}

		$this->assign('thumb',$thumb);

		//top category
		$M_category = D('Category');
		$top_category = array();
		$top_category = $M_category->getTopCategoryByCatid($goods['catid']);
		$this->assign('top_category',$top_category);

		//series 
		$M_series = D('Series');
		$series = array();
		$series = $M_series->getSeries($goods['seriesid']);
		$this->assign('series',$series);

		//param
		$param = array();
		$S_GoodsParam = D("GoodsParam","Service");
		$param = $S_GoodsParam->getGoodsParameter($goods['goodsid']);
		$this->assign("param",$param);

		//replace model 
		$model_replace = array();
		$model_replace = D('ModelReplace')->getModelbyModelid($goods['modelid']);
		$this->assign("model_replace",$model_replace);

		//resource
		$series_resource = array();
		$series_resource = $M_series->getSeriesResource($goods['seriesid']);
		$this->assign("series_resource",$series_resource);

		// model resource
		$model_resource = array();
		$model_res_where = array();
		$model_data = array();
		$model_data = D('Model')->getModel($goods['modelid']);

		if(!empty($model_data['resids']))
		{

			$model_resids = array();
			$model_resids = explode(',', $model_data['resids']);
			$model_res_where['resid'] = array('in',$model_resids);
			$model_resource = D('Resource')->getResourceData($model_res_where);
		}

		$this->assign("model_resource",$model_resource);
		
		//company
		$company = array();
		$M_company = D('Company');
		$com_where = array();
		if(!empty($series['companyids']))
		{
			$com_where['companyid'] = array('in',explode(',', $series['companyids']));
			$company = $M_company->getCompanyData($com_where,true);
		}
		$this->assign('company',$company);

		//recommend
		$recommend_model = array();
		$rec_where = array();
		$rec_where['seriesid'] = $goods['seriesid'];
		$rec_where[] = "goodsid<>".$goodsid;
		$recommend_model = $M_goods->getGoodsList($rec_where,0,6);
		$this->assign('recommend_model',$recommend_model['data']);


		/*seo*/
		$seo = '<title>'.$goods['title'].' '.$series['series_name'].' '.' '.$top_category['cat_name'].$goods['brand'].'-蹦蹦哒</title>';
		$seo .= '<meta name="keywords" content="'.$goods['title'].' '.$series['series_name'].' '.' '.$top_category['cat_name'].$goods['brand'].' '.$goods['model'].'" />';
		$seo .= '<meta name="description" content="'.$goods['title'].' '.$series['series_name'].' '.' '.$top_category['cat_name'].$goods['brand'].' '.$goods['model'].'" />';
		$seo .= '<link rel="canonical" href="'.$this->default_site.U('Goods/detail',array('goodsid'=>$goods['goodsid'])).'" />';
		$this->assign("seo",$seo);
		

		$this->display("Goods/goods_detail");

	}

}