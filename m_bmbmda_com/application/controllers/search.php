<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends MY_Controller {
	function __construct()
    {
        parent::__construct();
        $this->load->library('SphinxClient','','sphinx');
        $this->sphinx->SetServer('127.0.0.1', 9312);
        $this->sphinx->SetConnectTimeout ( 3 );
        $this->sphinx->SetArrayResult ( true );
        $this->sphinx->ResetFilters();
        $this->sphinx->ResetGroupBy();
    }

	public function search_detail()
	{
		$data = array();


		$keywords = $this->input->post('keywords','');
		if(empty($keywords))
		{
			$keywords = $this->uri->rsegment(3,0);
		}
		$keywords = trim($keywords);


		$data['keywords'] = $keywords;

		$limit = 10;
		$offset = 0;
		$current_page = intval($this->uri->rsegment(4,0));
		if($current_page <= 1)
		{
			$current_page = 1;
		}
		$offset = ($current_page - 1)*$limit;


		$search_data = array();
		$search_data = $this->get_data($keywords,$limit,$offset);

		$goodsids = array();
		$goodsids = $search_data['goodsids'];



		$goods = array();
		if(!empty($goodsids))
		{
			$goods = $this->db->select('*')->from('goods')->where_in('goodsid',$goodsids)->get()->result_array();
		}
			


		$data['goods'] = $goods;

		$total =  intval($search_data['total']);
		
        $total_page = 0;
        if($total > 1)
        {
        	$total_page = ceil($total/$limit);
        }
		

		$data['total_page'] = $total_page;
		$data['current_page'] = $current_page;

		$prev_link = '';
		if($current_page - 1 > 1)
		{
			$prev_link = site_url('search/search_detail/'.$keywords.'/'.($current_page - 1));
		}
		$data['prev_link'] = $prev_link;

		$next_link = '';
		if($current_page + 1 < $total_page)
		{
			$next_link = site_url('search/search_detail/'.$keywords.'/'.($current_page + 1));
		}
		$data['next_link'] = $next_link;

		if(!empty($current_page))
		{
			$url = site_url('search/search_detail/'.$keywords.'/'.$current_page);
		}else{
			$url = site_url('search/search_detail/'.$keywords);
		}




		//网址
		$site = $this->config->item("site");
		$data['site'] = $site;

		/*seo*/
		$seo = '';
		if(!empty($keywords))
		{
			$seo .= '<title>'.$keywords.'-bmbmda.com</title>';
		}else{
			$seo .= '<title>tyre searcher-bmbmda.com</title>';
		}


		$seo .= '<meta name="keywords" content=" '.$keywords.' bmbmda" />';
		$seo .= '<meta name="description" content="'.$keywords.'" />';
		$seo .= '<link rel="canonical" href="'.$url.'" />';
		$data['seo'] = $seo;


		$this->load->view('public/header',$data);
		$this->load->view('search_detail_index',$data);
		$this->load->view('public/footer',$data);

	}
    
    /*匹配数据*/
	private function get_data($keywords = '',$limit = 10,$offset = 0)
	{
		$keywords = trim($keywords);
		if(empty($keywords))
		{
			return array('total'=>0,'goodsids'=>array());
		}
		
        $keywords = preg_replace("/[^A-Za-z0-9\-\.\&]/i", '&:;', $keywords);
        // $title = preg_replace("/(\|)+/", '|', $title);

        $keywords = explode('&:;', $keywords);
        //过滤小于两个字符的
        $keywords_arr = array();
        foreach($keywords as $k => $v){
            $keywords_arr[] = "\"$v\"";
        }
        $keywords = implode('|', $keywords_arr);

        $this->sphinx->SetSortMode(SPH_SORT_RELEVANCE);//等价于在扩展模式中按"@weight DESC, @id ASC"排序
        $this->sphinx->SetMatchMode(SPH_MATCH_EXTENDED);//匹配模式
        $this->sphinx->SetLimits($offset,$limit);//匹配模式
        $data = array();
        $data = $this->sphinx->Query($keywords, 'bmbmda_goods');
        $goodsids = array();
        $total = 0;
        if(!empty($data['matches'])){
        	foreach ($data['matches'] as $key => $value) {
        		$goodsids[] = $value['attrs']['ugoodsid'];
        	}
        	$total = $data['total_found'];

        }

        return array('total'=>$total,'goodsids'=>$goodsids);

	}
}