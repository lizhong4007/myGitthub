<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {
	function __construct()
    {
        parent::__construct();
    }

	public function index()
	{

		$data = array();

		//推荐型号
		$model = array();
		$offet = rand(0,10000);
		$recommed_model = $this->db->distinct()->select('seriesid,model,goodsid')->from('goods')->limit(12,$offet)->get()->result_array();
		$data['recommed_model'] = $recommed_model;

		$category = array();
		$category = $this->db->select('catid,cat_alias,linkurl')->from('category')->where(array('is_show'=>1,'status'=>1,'parentid'=>0))->get()->result_array();

		foreach ($category as $key => $value) {
			//品牌
			$brandids = array();
			$brandids = $this->db->select('brandid')->distinct()->from('series')->limit(10,0)->where(array('catid'=>$value['catid']))->get()->result_array();
			if(empty($brandids))
			{
				unset($category[$key]);
				continue;
			}
			$brandids_tmp = array();
			foreach ($brandids as $brandid) {
				$brandids_tmp[] = $brandid['brandid'];
			}
			$brand = array();
			$brand = $this->db->select('brandid,brand_alias,linkurl')->from('brand')->where_in('brandid',$brandids_tmp)->limit(8,0)->get()->result_array();
			//系列
			$thumb = '';
			foreach ($brand as $k_brand=>$brandid_tmp) {
				$series = array();
				$series = $this->db->select('seriesid,series_alias,linkurl,thumb')->from('series')->where(array('catid'=>$value['catid'],'brandid'=>$brandid_tmp['brandid']))->limit(18,0)->get()->result_array();
				if(!empty($series[0]['thumb']))
				{
					$thumb = $series[0]['thumb'];
				}
				$brand[$k_brand]['series'] = $series;
			}
			$category[$key]['thumb'] = $thumb;
			$category[$key]['brand'] = $brand;

		}

		$data['category'] = $category;



		//网址
		$site = $this->config->item("site");
		$data['site'] = $site;

		
		$this->load->view('main_index', $data);
	}
}
