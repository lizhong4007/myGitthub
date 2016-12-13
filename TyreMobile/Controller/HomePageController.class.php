<?php
namespace TyreMobile\Controller;
use Think\Controller;
class HomePageController extends CommonController {
	public function index()
	{
		vendor('Sphinx.sphinxapi');
		$sphinx = new \SphinxClient();
		$sphinx->SetServer('127.0.0.1', 9312);
		$sphinx->SetConnectTimeout ( 3 );  
        $sphinx->SetArrayResult ( true );
		
		//顶级分类
		$M_category = D('Category');
		$top_category = array();
		$top_category = $M_category->getCategoryByParentid();

		$M_series = D('Series');
		$M_brand = D('Brand');
		$data = array();
		foreach ($top_category as $key => $value) {
			$sphinx->ResetFilters();//重置
			$sphinx->ResetGroupBy();
			$sphinx->setFilter('catid',array($value['catid']));
			$sphinx->SetGroupBy("brandid", SPH_GROUPBY_ATTR, "@count desc");
			$sphinx->SetGroupDistinct( "brandid");
			$sphinx->SetLimits(0,6);
			$tmp = array();
			$series = array();
			$brand = array();
			$tmp = $sphinx->Query('',"bmbmda_series");
			$tmp_data = array();
			if(!empty($tmp['matches']))
			{
				foreach ($tmp['matches'] as $k => $v) {
					$tmp_data[$k]['series'] = $M_series->getSeries($v['attrs']['useriesid']);
					$tmp_data[$k]['brand'] = $M_brand->getBrand($v['attrs']['brandid']);
				}
			}
			$value['series'] = $tmp_data;
			$data[] = $value;
		}

		foreach ($data as $key => $value) {
			if(count($value['series'])< 2)
			{
				unset($data[$key]);
			}
		}
		$this->assign('data',$data);


		/*seo*/
		$seo = '<title>蹦蹦哒轮胎</title>';
		$seo .= '<meta name="keywords" content="蹦蹦哒 轮胎 规格 型号 花纹 经销商" />';
		$seo .= '<meta name="description" content="" />';
		$seo .= '<link rel="canonical" href="http://www.bmbmda.com/" />';
		$this->assign("seo",$seo);

		
		$this->display("Main/main_list");
	}

}