<?php
namespace TyreWWW\Controller;
use Think\Controller;
class SearchController extends CommonController {
	
	/*搜索功能*/
	public function search(){
		$currentpage = (int)I('p',1);

		//搜索关键词
		$search_key = trim(I('search_key',''));
		$this->assign('search_key',$search_key);
		$search_key = strtoupper($search_key);
		if(empty($search_key))
		{
			$this->display('Public/404');
			die;
		}

		vendor('Sphinx.sphinxapi');
		$sphinx = new \SphinxClient();
		$sphinx->SetServer('localhost', 9312);
		$sphinx->SetConnectTimeout ( 3 );  
        $sphinx->SetArrayResult ( true );
		$sphinx->ResetFilters();//重置
		$sphinx->ResetGroupBy();
		$sphinx->SetMatchMode(SPH_MATCH_EXTENDED);

		//分页
        $limit = 20;//每页显示20
        $offset = $limit * ($currentpage - 1);//偏移量
        $totalrows = 0;//总数量

		$sphinx->SetLimits($offset, $limit, 1000);
        //搜索数据
        $data = array();

		$data = $sphinx->Query('@title '.$search_key,"bmbmda_goods");
		if(!empty($data['total'])){
			$totalrows = $data['total'];
		}

		$opt = array(
			"before_match"=>"<font style='font-weight:bold;color:#f00'>",
			"after_match"=>"</font>",
			'chunk_separator' => '...',
			'limit'    => 60,
			'around'   => 3,
			);
        
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
		

		//实例化商品参数
		$S_GoodsParam = D("GoodsParam","Service");
		$goods_data_tmp = array();
		foreach ($goods_data as $key => $value) {
			// $value = $sphinx->buildExcerpts($value,"bmbmda_goods",$search_key,$opt);
			$tmp = array();
			$tmp = $S_GoodsParam->getGoodsParameter($value['goodsid']);
			$value['param'] = $tmp;
			$goods_data_tmp[] = $value;
		}

        
		$pages = pages($totalrows,$currentpage);

		$this->assign("goods",$goods_data_tmp);
		$this->assign("totalrows",$totalrows);
		$this->assign("page",$pages);


		/*seo*/
		$seo = '<title>轮胎搜索器-bmbmda.com</title>';
		$seo .= '<meta name="keywords" content="蹦蹦哒 轮胎 规格 型号 花纹 经销商" />';
		$seo .= '<meta name="description" content="" />';
		$seo .= '<link rel="canonical" href="'.$this->default_site.U('Search/search_list',array('p'=>$currentpage)).'" />';
        $seo .= '<link rel="alternate" media="only screen and (max-width: 640px)" href="'.$this->default_mobile_site.U('Search/search_list',array('p'=>$currentpage)).'" />';
		$this->assign("seo",$seo);


		$this->display("Search/search_list");
	}
	

}