<?php
namespace TyreMobile\Controller;
use Think\Controller;
class SearchController extends CommonController {
	public function search_list()
	{
		$currentpage = (int)I('p',1);

		//搜索关键词
		$search_key = trim(I('q',''));
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
        $limit = 10;//每页显示20
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
			$goods_data =  M('Goods')->field("goodsid,model,seriesid,brand,title,en_title,thumb")->where($where)->select();
		}

		$M_series = D('Series');

		foreach ($goods_data as $key => $value) {
			$series = array();
			$series = $M_series->getSeries($value['seriesid']);
			$goods_data[$key]['series'] = $series;
		}
		

        
		$pages = pages($totalrows,$currentpage);


		$this->assign("goods",$goods_data);
		$this->assign("totalrows",$totalrows);
		$this->assign("page",$pages);
		$this->assign("currentpage",$currentpage);


		$this->display("Search/search_list");

	}

}