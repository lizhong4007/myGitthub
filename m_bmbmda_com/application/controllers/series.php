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

		//网址
		$site = $this->config->item("site");
		$data['site'] = $site;


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

		//顶级分类
		$category = array();
		$category = $this->get_category($series['catid']);
		$data['category'] = $category;

		// 品牌
	    $brand = array();
        $brand = $this->db->get_where('brand',array('brandid'=>$series['brandid']))->result_array();
        if(!empty($brand))
        {
        	$brand = array_pop($brand);
        }
        $data['brand'] = $brand;
		
		//处理图片
		$thumb = array();
		if(empty($series['thumb']))
		{
			$thumb[] = $site['image_default'];
		}else{
			$thumb[] = $series['thumb'];
		}

		if(!empty($series['thumb2']))
		{
			$thumb[] = $series['thumb2'];
		}

		if(!empty($series['thumb3']))
		{
			$thumb[] = $series['thumb3'];
		}
		$data['thumb'] = $thumb;

		//系列内容
		$series_content = array();
		$series_content = $this->db->get_where('series_content',array('seriesid'=>$seriesid,'language'=>1))->result_array();
		if(!empty($series_content))
		{
			$series_content = array_pop($series_content);
		}
		$data['series_content'] = $series_content;


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
		$prev_link = '';
		if($current_page - 1 > 1)
		{
			$prev_link = $next_link = site_url('series/series_detail/'.$seriesid.'/'.$series['linkurl'].'/'.($current_page - 1));
		}
		$total_page = ceil($total_rows/$limit);
		$next_link = '';
		if($current_page + 1 < $total_page)
		{
			$next_link = site_url('series/series_detail/'.$seriesid.'/'.$series['linkurl'].'/'.($current_page + 1));
		}

		$data['current_page'] = $current_page;
		$data['prev_link'] = $prev_link;
		$data['next_link'] = $next_link;

		$offset = ($current_page - 1) * $limit;
		$offset = intval($offset);
		if($offset <= 0)
		{
			$offset = 0;
		}


		$goods = array();
		$goods = $this->db->select('*')->limit($limit,$offset)->from('goods')->where(array('seriesid'=>$seriesid))->get()->result_array();

		$data['goods'] = $goods;


		//公司
		$company = array();
		$company = $this->get_company($seriesid);
		$data['company'] = $company;


		//recommend
		$recommend_series = array();
		$recommend_series = $this->db->select('seriesid,series_alias,linkurl')->from('series')->where(array('catid'=>$series['catid']))->limit(6,0)->get()->result_array();
		$data['recommend_series'] = $recommend_series;

		

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

	/**
    *获取系列经销商
    *@param int $seriesid 
    *@return array 空数组或数据
    */
	private function get_company($seriesid = 0)
	{
		$data = array();
		$seriesid = intval($seriesid);
		$companyids = array();
		$companyids = $this->db->select('companyids')->from('series')->where(array('seriesid'=>$seriesid))->get()->result_array();
		if(!empty($companyids))
		{
			$companyids = array_pop($companyids);
			foreach (explode(',',$companyids['companyids']) as $key => $value) {
				$company = array();
				$company = $this->db->get_where('company',array('companyid'=>$value))->result_array();
				if(!empty($company)){
					$company = array_pop($company);
					$distrubutor = array();
					$address_alias = '';
					if(!empty($company['distributorids']))
					{
						$distrubutor = $this->db->select('*')->from('company_distributor')->where_in('distributorid',explode(',',$company['distributorids']))->get()->result_array();
						if(!empty($distrubutor))
						{
							$distrubutor = array_shift($distrubutor);
							$address_alias_arr = array();
							$country = array();
							$country = $this->get_country($distrubutor['countryid']);
							if(!empty($country))
							{
								$address_alias_arr[] = $country['en_name'];
							}

							$state = array();
							$state = $this->get_state($distrubutor['stateid']);
							if(!empty($state))
							{
								$address_alias_arr[] = $state['en_name'];
							}

							$city = array();
							$city = $this->get_country($distrubutor['cityid']);
							if(!empty($city))
							{
								$address_alias_arr[] = $city['en_name'];
							}
							if(!empty($address_alias_arr))
							{
								$address_alias = implode(' ', $address_alias_arr);
							}
						}

					}
					$distrubutor['address_alias'] = $address_alias;
					$company['distributor'] = $distrubutor;
					$data[] = $company;
				}
			}
		}

		return $data;

	}

	/*获取国家*/
	private function get_country($countryid = 0)
	{
		$countryid = intval($countryid);
		if($countryid <= 0)
		{
			return array();
		}
		$data = array();
		$data = $this->db->get_where('country',array('countryid'=>$countryid))->result_array();
		if(!empty($data))
		{
			$data = array_pop($data);
		}
		return $data;

	}

	/*获取省份*/
	private function get_state($stateid = 0)
	{
		$stateid = intval($stateid);
		if($stateid <= 0)
		{
			return array();
		}
		$data = array();
		$data = $this->db->get_where('state',array('stateid'=>$stateid))->result_array();
		if(!empty($data))
		{
			$data = array_pop($data);
		}
		return $data;

	}

	/*获取城市*/
	private function get_city($cityid = 0)
	{
		$cityid = intval($cityid);
		if($cityid <= 0)
		{
			return array();
		}
		$data = array();
		$data = $this->db->get_where('city',array('cityid'=>$cityid))->result_array();
		if(!empty($data))
		{
			$data = array_pop($data);
		}
		return $data;

	}

	/**
    *顶级分类
    *只有两级
    *@param int $catid 分类id
    *@return array 空数组或数据
    */
	private function get_category($catid = 0)
	{
		$data = array();
		$catid = intval($catid);
		if($catid <= 0)
		{
			return array();
		}
		$data = $this->db->select('*')->from('category')->where(array('catid'=>$catid))->get()->result_array();
		if(!empty($data))
		{
			$data = array_pop($data);
			$parent_category = array();
			if(!empty($data['parentid']))
			{
				$parent_category = $this->db->select('*')->from('category')->where(array('catid'=>$data['parentid']))->get()->result_array();
				if(!empty($parent_category))
				{
					$parent_category = array_pop($parent_category);
					return $parent_category;
				}
			}
		}
		return $data;
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