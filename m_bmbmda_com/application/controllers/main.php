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
		$recommed_model = $this->db->distinct()->select('seriesid,model,goodsid')->from('goods')->limit(6,$offet)->get()->result_array();
		$data['recommed_model'] = $recommed_model;

		$category = array();
		$category = $this->db->select('catid,cat_alias,linkurl,parentid')->from('category')->where(array('is_show'=>1,'status'=>1,'parentid'=>0))->limit(4,0)->get()->result_array();

		$brand = array();
		$brand = $this->db->select('brandid,brand_alias,linkurl')->from('brand')->where(array('is_recommend'=>1))->limit(18,0)->get()->result_array();
		$data['brand'] = $brand;

		foreach ($category as $key => $value) {
			$sub_category = array();
			$sub_category = $this->db->select('catid')->from('category')->where(array('status'=>1,'parentid'=>$value['catid']))->get()->result_array();
			$where = array();
			$where[] = $value['catid'];
			if(!empty($sub_category))
			{
				foreach ($sub_category as $v) {
					$where[] = $v['catid'];
				}
			}
			$series = $this->db->select('seriesid,series_alias,linkurl,thumb')->from('series')->where_in('catid',$where)->where(array('status'=>1))->limit(18,0)->get()->result_array();;
			$category[$key]['series'] = $series;
		}


		$data['category'] = $category;



		//网址
		$site = $this->config->item("site");
		$data['site'] = $site;

		
		$this->load->view('main_index', $data);
	}
}
