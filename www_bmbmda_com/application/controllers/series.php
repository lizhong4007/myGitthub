<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Series extends MY_Controller {
	function __construct()
    {
        parent::__construct();
    }

	public function series_detail()
	{
		$data = array();
		$seriesid = intval($this->uri->rsegment(3,0));
		$series = array();
		$series = $this->db->get_where('series',array('seriesid'=>$seriesid))->result_array();
		if(empty($series))
		{
			show_404();
			die;
		}
		$series = array_pop($series);
		$data['series'] = $series;

		$series_arr = array();
		$series_arr = $this->db->select('*')->from('series')->where(array('catid'=>$series['catid']))->limit(15,0)->get()->result_array();
		$data['series_arr'] = $series_arr;
		$data['seriesid'] = $seriesid;
		// print_r($brandid);exit;

		//分页
		$total_rows = 0;
		$total_rows = array();
		$total_rows = $this->db->select('*')->from('goods')->where(array('seriesid'=>$seriesid))->count_all_results();


		$limit = 10;

		$current_page = 0;
		$current_page = intval($this->uri->rsegment(5,0));
		$uri_segment = 4;

		$page = '';
		$url = site_url('series/series_detail/'.$seriesid.'/'.$series['linkurl']);
		$page = $this->page($url,$total_rows,$limit,$uri_segment);
		$data['page'] = $page;

		$offset = ($current_page - 1) * $limit;
		$offset = intval($offset);
		if($offset <= 0)
		{
			$offset = 0;
		}


		$goods = array();
		$goods = $this->db->select('*')->limit($limit,$offset)->from('goods')->where(array('seriesid'=>$seriesid))->get()->result_array();

		$data['goods'] = $goods;

		//网址
		$site = $this->config->item("site");
		$data['site'] = $site;

		/*seo*/
		$seo = '<title>'.$series['series_alias'].'-bmbmda.com</title>';
		$seo .= '<meta name="keywords" content=" '.$series['series_alias'].' bmbmda" />';
		$seo .= '<meta name="description" content="'.$series['series_alias'].'" />';
		$seo .= '<link rel="canonical" href="'.$url.'" />';
		$data['seo'] = $seo;

		$this->load->view('public/header',$data);
		$this->load->view('series_detail_index',$data);
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