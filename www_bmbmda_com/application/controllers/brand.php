<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand extends MY_Controller {
	function __construct()
    {
        parent::__construct();
    }

	public function brand_detail()
	{
		$data = array();
		$brand_param = $this->uri->rsegment(3,0);
		$catid = 0;
		$brandid = 0;
		if(empty($brand_param))
		{
			show_404();
			die;
		}else{
			$cat_param_tmp = array();
			$cat_param_tmp = explode('_', $brand_param);
			$brandid = $cat_param_tmp[0];
			if(!empty($cat_param_tmp[1]))
			{
				$catid = intval($cat_param_tmp[1]);
			}
		}
		$brand = array();
		$brand = $this->db->get_where('brand',array('brandid'=>$brandid))->result_array();
		if(empty($brand))
		{
			show_404();
			die;
		}
		$brand = array_pop($brand);
		$data['brand'] = $brand;

		$category_info = array();
		if(!empty($catid))
		{
			$category_info = $this->db->get_where('category',array('catid'=>$catid))->result_array();
			if(empty($category_info))
			{
				show_404();
				die;
			}
			$category_info = array_pop($category_info);
		}
		

		$catids = array();
		$catids = $this->db->distinct()->select('catid')->from('series')->where(array('brandid'=>$brandid))->get()->result_array();
		$category = array();
		if(!empty($catids))
		{
			$catids_tmp = array();
			foreach ($catids as $key => $value) {
				$catids_tmp[] = $value['catid'];
			}
			$category = $this->db->select('*')->from('category')->where_in('catid',$catids_tmp)->where(array('status'=>1))->limit(15,0)->get()->result_array();

		}
		$data['category'] = $category;
		$data['catid'] = $catid;
		// print_r($brandid);exit;

		//分页
		$total_rows = 0;
		$total_rows = array();
		$where = array();
		$where['brandid'] = $brandid;
		if(!empty($catid))
		{
			$where['catid'] = $catid;
		}
		$total_rows = $this->db->select('*')->from('series')->where($where)->count_all_results();


		$limit = 10;

		$current_page = 0;
		$current_page = intval($this->uri->rsegment(5,0));
		$uri_segment = 4;

		$page = '';
		$url = site_url('brand/brand_detail/'.$brand_param.'/'.$brand['linkurl']);
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
		$title = $brand['brand_alias'];
		if(!empty($category_info))
		{
			$title = $title.' '.$category_info['cat_alias'];
		}
		$seo = '<title>'.$title.'-bmbmda.com</title>';
		$seo .= '<meta name="keywords" content=" '.$title.' bmbmda" />';
		$seo .= '<meta name="description" content="'.$title.'" />';
		$seo .= '<link rel="canonical" href="'.$url.'" />';
		$data['seo'] = $seo;

		$this->load->view('public/header',$data);
		$this->load->view('brand_detail_index',$data);
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