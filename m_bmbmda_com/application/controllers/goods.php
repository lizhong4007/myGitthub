<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Goods extends MY_Controller {
	function __construct()
    {
        parent::__construct();
        $this->load->model("goodsparam_model","M_param");
    }

	public function goods_detail()
	{
		$data = array();

		//网址
		$site = $this->config->item("site");
		$data['site'] = $site;



		$goodsid = intval($this->uri->rsegment(3,0));
		$goods = array();
		$goods = $this->db->select('*')->from('goods')->where(array('goodsid'=>$goodsid))->get()->result_array();
		if(empty($goods))
		{
			show_404();
			die;
		}

		

		$goods = array_pop($goods);
		$data['goods'] = $goods;

		//处理图片
		$thumb = array();
		if(empty($goods['thumb']))
		{
			$thumb[] = $site['image_default'];
		}else{
			$thumb[] = $goods['thumb'];
		}

		if(!empty($goods['thumb2']))
		{
			$thumb[] = $goods['thumb2'];
		}

		if(!empty($goods['thumb3']))
		{
			$thumb[] = $goods['thumb3'];
		}
		$data['thumb'] = $thumb;
        
        //顶级分类
		$category = array();
		$category = $this->get_category($goods['catid']);
		$data['category'] = $category;

		//系列
        $series = array();
        $series = $this->get_series($goods['seriesid']);
        $data['series'] = $series;
        


	    // 品牌
	    $brand = array();
        $brand = $this->db->get_where('brand',array('brandid'=>$goods['brandid']))->result_array();
        if(!empty($brand))
        {
        	$brand = array_pop($brand);
        }
        $data['brand'] = $brand;
		
		$param = array();
		$param = $this->M_param->getGoodsParameter($goodsid);
		$data['param'] = $param;

		//系列内容
		$series_content = array();
		$series_content = $this->db->get_where('series_content',array('seriesid'=>$goods['seriesid'],'language'=>1))->result_array();
		if(!empty($series_content))
		{
			$series_content = array_pop($series_content);
		}
		$data['series_content'] = $series_content;


		//系列资源
        $series_resource = array();
        try{
	        $series_resource = $this->get_series_resource($goods['seriesid']);
        }catch(Exception $e){

        }


        //型号资源
        $model_resource = array();
        try{
	        $model_resource = $this->get_model_resource($goods['modelid']);
        }catch(Exception $e){

        }

        //产品资源
        $goods_resource = array();
        $goods_resource = array_merge_recursive($series_resource,$model_resource);
        //合并资源
        $resource = array();
        if(!empty($goods_resource['others']))
        {
        	foreach ($goods_resource['others'] as $key => $value) {
        		$resource[] = $value['resource'];
        	}
        }

        //处理手册
        $manual = array();
        if(!empty($goods_resource['manual']))
        {
        	foreach ($goods_resource['manual'] as $key => $value) {
        		$manual[] = $value;
        	}
        }
        $data['manual'] = $manual;
        $data['resource'] = $resource;

        //花纹
        $series_thread = array();
        $series_thread = $this->get_series_thread($goods['seriesid']);
        $data['series_thread'] = $series_thread;


		/*//产品内容
		$goods_content = array();
		$goods_content = $this->db->get_where('goods_content',array('goodsid'=>$goods['goodsid']))->result_array();
		$data['goods_content'] = $goods_content;*/

		//公司
		$company = array();
		$company = $this->get_company($goods['modelid']);
		$data['company'] = $company;

		//recommend
		$recommend_model = array();
		$recommend_model = $this->db->select('goodsid,model,linkurl')->from('goods')->where(array('catid'=>$goods['catid']))->limit(6,0)->get()->result_array();
		$data['recommend_model'] = $recommend_model;


		

		/*seo*/
		$url = site_url('goods/goods_detail/'.$goodsid.'/'.$goods['linkurl']);
		$seo = '<title>'.$goods['en_title'].'-bmbmda.com</title>';
		$seo .= '<meta name="keywords" content=" '.$goods['en_title'].' '.$series['series_alias'].'" />';
		$seo .= '<meta name="description" content="'.$goods['en_title'].'" />';
		$seo .= '<link rel="canonical" href="'.$url.'" />';
		$data['seo'] = $seo;


		$this->load->view('public/header',$data);
		$this->load->view('goods_detail_index', $data);
		$this->load->view('public/footer',$data);

	}

	/**
    *获取经销商，同一型号
    *@param int $modelid 
    *@return array 空数组或数据
    */
	private function get_company($modelid = 0)
	{
		$data = array();
		$modelid = intval($modelid);
		$goods = array();
		$goods = $this->db->select('companyid')->from('goods')->where(array('modelid'=>$modelid))->get()->result_array();
		if(!empty($goods))
		{
			foreach ($goods as $key => $value) {
				$company = array();
				$company = $this->db->get_where('company',array('companyid'=>$value['companyid']))->result_array();
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



	/**
    *系列花纹
    *花纹(系列资源存在系列资源表，后面尽量统一表，都存放在资源表中)
    *@param int $seriesid 系列id
    *@return array 空数组或数据
    */
	private function get_series_thread($seriesid = 0)
	{
		$data = array();
		$seriesid = intval($seriesid);
		if($seriesid <= 0)
		{
			return array();
		}
		$data = $this->db->select('*')->from('series_resource')->where(array('seriesid'=>$seriesid))->get()->result_array();
		return $data;
	}
    
    /**
    *系列资源
    *花纹(系列资源存在系列资源表，后面尽量统一表，都存放在资源表中)
    *@param int $seriesid 系列id
    *@return array 空数组或数据
    *@throws Exception
    */
	private function get_series_resource($seriesid)
	{
		$data = array();
		$series = array();
		$series = $this->get_series($seriesid);
		if(empty($series))
		{
			throw new Exception("series not exited", 1);
		}
		//系列手册
		$resids = array();
		$resids = explode(',', $series['resids']);
		$data = $this->get_resource($resids);
		return $data;
	}

	/**
    *型号资源
    *@param int $modelid 型号id
    *@return array 空数组或数据
    */
	private function get_resource($resids = array())
	{
		$data = array();
		$data_tmp = array();
		$data_tmp['manual'] = array();
		$data_tmp['others'] = array();
		if(empty($resids))
		{
			return $data_tmp;
		}
		if(!is_array($resids))
		{
			$resids = array($resids);
		}
		$data = $this->db->select('*')->from('resource')->where_in('resid',$resids)->get()->result_array();
		if(!empty($data))
		{
			foreach ($data as $key => $value) {
				if(strcmp(strval($value['res_type']), 'manual') == 0)
				{
					$data_tmp['manual'][] = $value;
				}else{
					$data_tmp['others'][] = $value;
				}

			}

		}
		return $data_tmp;
	}

	/**
    *型号资源
    *@param int $modelid 型号id
    *@return array 空数组或数据
    *@throws Exception
    */
	private function get_model_resource($modelid = 0)
	{
		$data = array();
		$model = array();
		$model = $this->get_model($modelid);
		if(empty($model))
		{
			throw new Exception("model not exited", 1);
		}
		$model_resids = array();
		$model_resids = explode(',', $model['resids']);
		$data = $this->get_resource($model_resids);

		return $data;
	}

	//获取型号
	private function get_model($modelid = 0)
	{
		$data = array();
		$modelid = intval($modelid);
		if($modelid <= 0)
		{
			return array();
		}
		$model = array();
		$model = $this->db->get_where('model',array('modelid'=>$modelid))->result_array();
		if(!empty($model))
		{
			$model = array_pop($model);
		}
		return $model;
	}

	//获取系列
	private function get_series($seriesid = 0)
	{
		$seriesid = intval($seriesid);
		if($seriesid <= 0)
		{
			return array();
		}
		$series = array();
		$series = $this->db->get_where('series',array('seriesid'=>$seriesid))->result_array();
		if(!empty($series))
		{
			$series = array_pop($series);
		}
		return $series;
	}
}