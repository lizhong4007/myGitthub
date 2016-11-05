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

		//分页
        $limit = 20;//每页显示20
        $offset = $limit * ($currentpage - 1);//偏移量
        $totalrows = 0;//总数量

		$sphinx->SetLimits($offset, $limit, 1000);
        //搜索数据
        $data = array();

		$data = $sphinx->Query($search_key,"bmbmda_goods");
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

		$this->display("Search/search_list");
	}
	

}