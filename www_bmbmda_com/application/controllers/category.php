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
		$total_rows = array();
		$where = array();
		$where['catid'] = $catid;
		if(!empty($brandid))
		{
			$where['brandid'] = $brandid;
		}
		$total_rows = $this->db->select('*')->from('series')->where($where)->count_all_results();


		$limit = 10;

		$current_page = 0;
		$current_page = intval($this->uri->rsegment(5,0));
		$uri_segment = 4;

		$page = '';
		$url = site_url('category/category_detail/'.$cat_param.'/'.$category['linkurl']);
		$page = $this->page($url,$total_rows,$limit,$uri_segment);
		$data['page'] = $page;

		$offset = ($current_page - 1) * $limit;
		$offset = intval($offset);
		if($offset <= 0)
		{
			$offset = 0;
		}


		$series = array();
		$series = $this->db->select('*')->limit($limit,$offset)->from('series')->where($where)->get()->result_array();

		$data['series'] = $series;

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

	private function page($url = '',$total_rows,$limit = 10,$uri_segment)
	{
		$this->load->library('pagination');

		$config['base_url'] = $url;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$config['num_links'] = 3;
		$config['use_page_numbers'] = TRUE;

		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['first_link'] = 'First';

		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';

		$config['prev_link'] = false;
		$config['next_link'] = false;

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li><a class="on">';
		$config['cur_tag_close'] = '</a></li>';


		$this->pagination->initialize($config);

		$page = '';
		$page = $this->pagination->create_links();

		return $page;
	}
}