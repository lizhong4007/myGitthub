<?php
namespace TyreMobile\Controller;
use Think\Controller;
class BrandController extends CommonController {
	public function brand_list()
	{
		$brandid = intval(I('brandid',''));
		//brand
		$M_brand = D('Brand');
		$brand = array();
		$brand = $M_brand->getBrand($brandid);
		if(empty($brand))
		{
			$this->display("Public:404");
			die;
		}
		$this->assign('brand',$brand);
		
		//series
		$series = array();
		$series = $this->get_series($brandid);
		$this->assign('series',$series);

        //recommend brand
        $recommend_brand = array();
        $rec_where = array();
        $rec_where['is_recommend'] = 1;
        $rec_where[] = 'brandid<>'.$brandid;
        $recommend_brand = $M_brand ->getBrandList($rec_where,0,4);
        $this->assign('recommend_brand',$recommend_brand['data']);

        /*seo*/
		$seo = '<title>'.$brand['brand_name'].'-蹦蹦哒</title>';
		$seo .= '<meta name="keywords" content="'.$brand['brand_name'].' 轮胎品牌 轮胎 花纹" />';
		$seo .= '<meta name="description" content="蹦蹦哒'.$brand['brand_name'].'品牌下各种各样的轮胎花纹" />';
		$seo .= '<link rel="canonical" href="'.$this->default_site.U('Brand/brand_list',array('brandid'=>$brandid)).'" />';
		$this->assign("seo",$seo);



		$this->display("Brand/brand_list");

	}

	/*获取系列，并将系列按分类排序*/ 
	private function get_series($brandid = 0)
	{
		$data = array();
		if(empty($brandid))
		{
			return array();
		}

		$M_series = D('Series');
		$category = array();
		$category = $M_series->distinct(true)->field('catid')->where(array('brandid'=>$brandid))->select();
		//top category
		$M_category = D('Category');
		$M_model = D('Model');
		foreach ($category as $key => $value) {
			$category_tmp = array();
			$category_tmp = $M_category->getCategory($value['catid']);
			$series_tmp = array();
			$series_tmp = $M_series->getSeriesList(array('catid'=>$value['catid'],'brandid'=>$brandid),0,6);
			if(empty($category_tmp ) or empty($series_tmp))
			{
				continue;
			}
			//判断是否有型号数据
			$model = array();
			$model = $M_model->getModelData(array('brandid'=>$brandid,'catid'=>$value['catid']));
			if(empty($model))
			{
				$category_tmp['status'] = 0;
			}
			$category_tmp['series'] = $series_tmp['data'];
			$data[] = $category_tmp;
		}
		return $data;

	}

}