<?php
namespace TyreWWW\Controller;
use Think\Controller;
class SeriesController extends CommonController {

	/*商品系列 列表*/
	public function series_list(){
		// 系列
		$seriesid = I('seriesid','');
		$this->assign("seriesid",$seriesid);
		$M_series = D("Series");
		$nav_series = array();
		$nav_series = $M_series->getSeries($seriesid);
		if(empty($nav_series))
		{
			$this->display("Public/404");
			die;
		}


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

		//筛选条件
		$this->filter();
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


		/*seo*/
		$seo = '<title>'.$nav_series['series_name'].' '.$current_category['cat_name'].' '.$brand['brand_name'].'-bmbmda</title>';
		$seo .= '<meta name="keywords" content="'.$nav_series['series_name'].' '.$current_category['cat_name'].' '.$brand['brand_name'].' 花纹 速度级别 尺寸 扁平比 帘布层评级" />';
		$seo .= '<meta name="description" content="'.$brand['brand_name'].'轮胎下的不同花纹" />';
		$seo .= '<link rel="canonical" href="'.$this->default_site.U('Series/series_list',array('seriesid'=>$seriesid,'p'=>$p)).'" />';
        $seo .= '<link rel="alternate" media="only screen and (max-width: 640px)" href="'.$this->default_mobile_site.U('Series/series_list',array('seriesid'=>$seriesid,'p'=>$p)).'" />';
		$this->assign("seo",$seo);


		$this->display("Series/series_list");
	}
    
    /*筛选条件*/
	private function filter()
	{
		$goods_filter = array();
	    $default_param = M('goods_default_para')->select();
	    foreach ($default_param as $key => $value) {
	    	$tmp = array();
	    	$tmp = M('goods_default_value')->where(array('dparaid'=>$value['dparaid']))->select();
	    	$goods_filter[] = array(
	    		'name'=>$value['param'],
	    		'dparaid'=>$value['dparaid'],
			   	'value'=>$tmp,
	    		);
	    }
		$this->assign('goods_filter',$goods_filter);
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
			foreach ($series as $key => $value) {
				$series[$key]['url'] = U('series/series_list',array('seriesid'=>$value['seriesid']));
			}
			echo json_encode(array('code'=>1,'message'=>$series));
			die;
		}else{
			echo json_encode(array('code'=>0));
			die;
		}
	}

	/*根据赛选条件查询商品*/
	public function get_filter_goods()
	{
		vendor('Sphinx.sphinxapi');
		$sphinx = new \SphinxClient();
		$sphinx->SetServer('localhost', 9312);
		$sphinx->SetConnectTimeout ( 3 );  
        $sphinx->SetArrayResult ( true );
		$sphinx->ResetFilters();//重置
		$sphinx->ResetGroupBy();

		$dparaid = I('post.paraid','');
		$dvid = I('post.t_vid','');
		$seriesid = (int)trim(I('post.seriesid',''));
		$currentpage = I('post.currentpage',1);//当前页
		//分页
        $limit = 20;//每页显示20
        $offset = $limit * ($currentpage - 1);//偏移量
        $totalrows = 0;//总数量

		$sphinx->SetLimits($offset, $limit, 1000);

		foreach ($dvid as $key => $value) {
			if(!empty($value))
			{
				$sphinx->setFilter('dparaids',array($dparaid[$key]));
				$sphinx->setFilter('dvids',array($value));
			}
		}
		$sphinx->setFilter('seriesid',array($seriesid));

        $data = array();

		$data = $sphinx->Query('',"bmbmda_goods");
		if(!empty($data['total'])){
			$totalrows = $data['total'];
		}

		$goodsids = array();
		$goods_data = array();
		if(!empty($data['matches']))
		{
			$where = array();
			foreach ($data['matches'] as $key => $value) {
				$goodsids[] = $value['attrs']['ugoodsid'];
			}
			$where['goodsid'] = array('in',$goodsids);
			$goods_data =  M('Goods')->field("goodsid,model,brand,title,en_title,thumb")->where($where)->select();
		}
		

		//实例化商品参数服务
		$S_GoodsParam = D("GoodsParam","Service");
		$goods_data_tmp = array();
		foreach ($goods_data as $key => $value) {
			$tmp = array();
			$tmp = $S_GoodsParam->getGoodsParameter($value['goodsid']);
			$param_tmp = array();
			foreach ($tmp as $k => $v) {
				$param_tmp[] = array($v['param'],$v['value']);
			}
			$value['param'] = $param_tmp;
			$value['brand_name'] = L('ADMIN_BRAND');
			$value['model_name'] = L('ADMIN_MODEL');
			$value['url'] = U('goods/detail',array('goodsid'=>$value['goodsid']));
			if(empty($value['max_price']))
			{
				$value['price_str'] = '';
			}else{
				$value['price_str'] = $value['min_price'];
			}
			if(empty($value['thumb']))
			{
				$value['thumb'] = $default_image;
			}
			$goods_data_tmp[] = $value;
		}
		echo json_encode(array('data'=>$goods_data_tmp,'totalrows'=>$totalrows,'currentpage'=>$currentpage));
	}
}