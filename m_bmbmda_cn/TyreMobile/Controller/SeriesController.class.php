<?php
namespace TyreMobile\Controller;
use Think\Controller;
class SeriesController extends CommonController {
	public function series_list()
	{
		$seriesid = intval(I('seriesid',''));
		$M_series = D('Series');
		$series = array();
		$series = $M_series->getSeries($seriesid,true);
		if(empty($series))
		{
			$this->display("Public:404");
			die;
		}
		$this->assign('series',$series);

		$thumb = array();
		if(empty($series['thumb']))
		{
			$default_image = '';
			$default_image = $this->default_image;
			$default_image = str_replace($this->site_imagedomain, '', $default_image);
			$thumb[] = $default_image;
		}else{
			$thumb[] = $series['thumb'];
		}

		if(!empty($series['thumb2']))
		{
			$thumb[] = $series['thumb2'];
		}

		if(!empty($series['thumb3']))
		{
			$thumb[] = $series['thumb3'];
		}

		$this->assign('thumb',$thumb);

		//brand
		$M_brand = D('Brand');
		$brand = array();
		$brand = $M_brand->getBrand($series['brandid']);
		$this->assign('brand',$brand);

		//top category
		$M_category = D('Category');
		$top_category = array();
		$top_category = $M_category->getTopCategoryByCatid($series['catid']);
		$this->assign('top_category',$top_category);

		//goods（model）
		$M_goods = D('Goods');
		$goods = array();
		$p = intval(I('p',1));
		$goods = $M_goods->getGoodsList(array('seriesid'=>$seriesid),$p,12);
		$this->assign('goods',$goods);

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
		$recommend_series = array();
		$rec_where = array();
		$rec_where['catid'] = $top_category['catid'];
		$rec_where[] = "seriesid<>".$seriesid;
		$recommend_series = $M_series->getSeriesList($rec_where,0,6);
		$this->assign('recommend_series',$recommend_series['data']);



		/*seo*/
		$seo = '<title>'.$series['series_name'].' '.$top_category['cat_name'].' '.$brand['brand_name'].'-蹦蹦哒</title>';
		$seo .= '<meta name="keywords" content="'.$series['series_name'].' '.$top_category['cat_name'].' '.$brand['brand_name'].' 花纹 速度级别 尺寸 扁平比 帘布层评级" />';
		$seo .= '<meta name="description" content="'.$brand['brand_name'].'轮胎下的不同花纹" />';
		$seo .= '<link rel="canonical" href="'.$this->default_site.U('Series/series_list',array('seriesid'=>$seriesid,'p'=>$p)).'" />';
		$this->assign("seo",$seo);


		$this->display("Series/series_list");


	}

}