<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller {
	function __construct()
    {
        parent::__construct();
    }

	public function category_detail()
	{
		$data = array();
		$cat_param = $this->uri->rsegment(3,0);
		$catid = 0;
		$brandid = 0;
		if(empty($cat_param))
		{
			show_404();
			die;
		}else{
			$cat_param_tmp = array();
			$cat_param_tmp = explode('_', $cat_param);
			$catid = $cat_param_tmp[0];
			if(!empty($cat_param_tmp[1]))
			{
				$brandid = intval($cat_param_tmp[1]);
			}
		}
		//分类
		$category = array();
		$category = $this->db->get_where('category',array('catid'=>$catid))->result_array();
		if(empty($category))
		{
			show_404();
			die;
		}
		$category = array_pop($category);
		$data['category'] = $category;
        //是否有品牌
		$brand_info = array();
		if(!empty($brandid))
		{
			$brand_info = $this->db->get_where('brand',array('brandid'=>$brandid))->result_array();
			if(empty($brand_info))
			{
				show_404();
				die;
			}
			$brand_info = array_pop($brand_info);
		}

		$brandids = array();
		$brandids = $this->db->distinct()->select('brandid')->from('series')->where_in('catid',array($catid,$category['parentid']))->get()->result_array();
		$brand = array();
		if(!empty($brandids))
		{
			$brandids_tmp = array();
			foreach ($brandids as $key => $value) {
				$brandids_tmp[] = $value['brandid'];
			}
			$brand = $this->db->select('*')->from('brand')->where_in('brandid',$brandids_tmp)->where(array('is_recommend'=>1))->limit(15,0)->get()->result_array();

		}
		$data['brand'] = $brand;
		$data['brandid'] = $brandid;
		// print_r($brandid);exit;

		//分页
		$total_rows = 0;
		$where = array();
		$where['catid'] = $catid;
		if(!empty($brandid))
		{
			$where['brandid'] = $brandid;
		}
		$total_rows = $this->db->select('*')->from('series')->where($where)->count_all_results();


		$limit = 10;
		$current_page = intval($this->uri->rsegment(5,0));
		if($current_page <= 1)
		{
			$current_page = 1;
		}
		$total_page = ceil($total_rows/$limit);

		$offset = ($current_page - 1) * $limit;
		$offset = intval($offset);
		if($offset <= 0)
		{
			$offset = 0;
		}

		$data['total_page'] = $total_page;
		$data['current_page'] = $current_page;

		$prev_link = '';
		if($current_page - 1 > 1)
		{
			$prev_link = site_url('category/category_detail/'.$cat_param.'/'.$category['linkurl'].'/'.($current_page - 1));
		}
		$data['prev_link'] = $prev_link;

		$next_link = '';
		if($current_page + 1 < $total_page)
		{
			$next_link = site_url('category/category_detail/'.$cat_param.'/'.$category['linkurl'].'/'.($current_page + 1));
		}
		$data['next_link'] = $next_link;


		$series = array();
		$series = $this->db->select('*')->limit($limit,$offset)->from('series')->where($where)->get()->result_array();

		$data['series'] = $series;

		if(!empty($current_page))
		{
			$url = site_url('category/category_detail/'.$cat_param.'/'.$category['linkurl'].'/'.$current_page);
		}else{
			$url = site_url('category/category_detail/'.$cat_param.'/'.$category['linkurl']);
		}

		//网址
		$site = $this->config->item("site");
		$data['site'] = $site;

		/*seo*/
		$title = $category['cat_alias'];
		if(!empty($brand_info))
		{
			$title = $title.' '.$brand_info['brand_alias'];
		}
		$seo = '<title>'.$title.'-bmbmda.com</title>';
		$seo .= '<meta name="keywords" content=" '.$title.' bmbmda.com" />';
		$seo .= '<meta name="description" content="'.$title.'" />';
		$seo .= '<link rel="canonical" href="'.$url.'" />';
		$data['seo'] = $seo;

		$this->load->view('public/header',$data);
		$this->load->view('category_detail_index',$data);
		$this->load->view('public/footer',$data);

	}

	
}