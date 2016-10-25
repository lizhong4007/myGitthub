<?php
namespace tyreManage\Controller;
use Think\Controller;
/**
* @HQtag: Company operation
*/
class CompanyController extends CommonController {
	/**
	* @HQtag: Company List
	*/
	public function CompanyList()
	{
		$data  = array();
		$where = $this->Search();
		$p=(int)I('p',1);;
		$size = 20;
		$data = D('Company')->getCompanyList($where,$p,$size);
		$this->assign('data',$data['data']);
		$this->assign('page',$data['page']);
        $this->display('Company/CompanyList');
	}
	/**
	 *搜索框搜索条件
	*/
	private function Search()
	{
		$serarch = I('searched','');
		$where = array("1");
		if(!empty($serarch) and md5($serarch) == '8ae282bece4a312bbc5595c60eedc0e6')
		{
			$companyname = I('companyname','');
			$companyname = trim($companyname);
			if(!empty($companyname))
			{
			   $where[] = "`company_name` like '%".$companyname."%' or `company_alias` like '%".$companyname."%' or `companyid` = '".$companyname."'";  
			}
			$this->assign('companyname',$companyname);
		}
		return $where;
	}
	/**
	* @HQtag: Add Company
	*/
	public function addCompany()
	{
		$error = '';
		$companyid = '';
		$save = I('post.save','');
		if(!empty($save)){
			if(md5($save) == '43781db5c40ecc39fd718685594f0956')
			{
				//检查公司数据
				$company = I('post.data','');
				$model = I('post.model','');
				$brand = I('post.brand','');				
				$company['operation_mode'] = $model;
				$company['brandids'] = $brand;
				// 检查公司数据
				if(empty($company['brandids']))
				{
					echo json_encode(array("code"=>0,"message"=>L('ADMIN_BRAND').L('ADMIN_NOTEMPTY')));
					exit;
				}else{
					$company['brandids'] = implode(',', $company['brandids']);
				}
				if(empty($company['company_name']) or empty($company['company_alias']))
				{
					echo json_encode(array("code"=>0,"message"=>L('COMPANY').L('ADMIN_NOTEMPTY')));
					exit;
				}
				if(empty($company['operation_mode']))
				{
					echo json_encode(array("code"=>0,"message"=>L('MANAGEMENT_MODEL').L('ADMIN_NOTEMPTY')));
					exit;
				}
				if(empty($company['brandids']))
				{
					echo json_encode(array("code"=>0,"message"=>L('ADMIN_BRAND').L('ADMIN_NOTEMPTY')));
					exit;
				}
				//检查经销商数据
				$distributor = I('post.distributor','');
				foreach ($distributor as $key => $value) {
					if(empty($value['provinceid']))
					{
						$error = L('ADMIN_PROVINCE').L('ADMIN_NOTEMPTY');
						break;
					}
					if(empty($value['address']))
					{
						$error = L('DEAIL_ADDRESS').L('ADMIN_NOTEMPTY');
						break;
					}
					if(!empty($value['site']))
					{
						if(!preg_match("/[http|https]:\/\//i",$value['site']))
						{
							$error = L('CHECK_SITE');
							break;
						}
					}
				}
				if($error)
				{
					echo json_encode(array("code"=>0,"message"=>$error));
					exit;
				}
				$result = '';
				if(empty($company['companyid']))
				{//添加
					$result = $this->addCompanyData($company,$distributor);
				}else{//修改
					$companyid = $company['companyid'];
					unset($company['companyid']);
					$result = $this->updateCompanyData($company,$distributor,$companyid);
				}
				echo json_encode($result);
				exit;
			}
		}
		$province = D('Area')->getAllProvince();
		$this->assign('province',$province);
		$brand = D('Brand')->getAllBrand();
		$this->assign('brand',$brand);
		$companyid = I('get.company_id','');
		if(!empty($companyid))
		{
		    $this->infoCompany($companyid);
			$this->display('Company/UpdateCompany');
		}else{
            $this->display('Company/AddCompany');
		}
	}
	/**
	* @: 根据公司id获取公司相关数据
	*/
	private function infoCompany($companyid = '')
	{
		if(empty($companyid)) return false;
		$info = '';
		$info = D('Company')->getCompany($companyid);
		$distributorids = explode(',', $info['distributorids']);
		$distributor_where = array();
		if(!empty($distributorids))
		{
			$area_model = D('Area');
			$distributor = D('CompanyDistributor')->getDistributorData(array('distributorid'=>array('in',$distributorids)));
			foreach ($distributor as $key => $value) {
				$distributor[$key]['city_data'] = $area_model->getCityByParentid($value['provinceid']);
				$distributor[$key]['area_data'] = $area_model->getAreaByParentid($value['cityid']);
				// 将数据分割成数组
				$distributor[$key]['telephone'] = explode(',', $value['telephone']);
				$distributor[$key]['contacts'] = explode(',', $value['contacts']);
				$distributor[$key]['email'] = explode(',', $value['email']);
				$distributor[$key]['fax'] = explode(',', $value['fax']);
				$distributor[$key]['platform'] = explode(',', $value['platform']);
				$distributor[$key]['account'] = explode(',', $value['account']);
			}
			$this->assign('distributor_data',$distributor);
		}
		$this->assign('data',$info);
		return $info;
	}
	/**
	* @: 获取地区数据
	*/
	public function getArea()
	{
		$parentid = I('post.id','');
		if(!empty($parentid))
		{
			$type = I('post.type','');
			$data = array();
			if($type == 'p')//省
			{
				$data = D('Area')->getCityByParentid($parentid);

			}elseif($type == 'c')//省
			{
				$data = D('Area')->getAreaByParentid($parentid);
				
			}
			echo json_encode(array('data'=>$data));
			exit;
		}
	}
	/**
	* @: 向Company表中添加数据
	*/
	private function addCompanyData($company = array(),$distributor = array())
	{
		//检查数据是否存在
		$where = array();
		$where['company_alias'] = $company['company_alias'];
		$where['domain'] = $company['domain'];
		$where['_logic'] = 'or';
		$company_info = '';
		$company_info = D('Company')->getCompanyData($where);
		if($company_info)
		{
			return array('code'=>0,'message'=>L('COMPANY').L('ADMIN_EXISTED'));
		}
		//生成经销商数据
		$distributorids = array();
		$distributor_model = D('CompanyDistributor');				
		foreach ($distributor as $key => $value) {
			$tmp = '';
			$tmp = $distributor_model->checkDistributor($value);
			if($tmp)
			{
				$distributorids[] = $tmp['distributorid'];
				continue;
			}
			$distributorid = '';
			$distributorid = $distributor_model->addDistributor($value);
			if($distributorid)
			{
				$distributorids[] = $distributorid;
			}
		}
		//添加公司
		if(empty($distributorids))
		{
			return array('code'=>0,'message'=>L('DISTRIBUTOR').L('ADMIN_ADD').L('ADMIN_FAILED'));
		}else{
			$company['distributorids'] = implode(',',$distributorids);
		}
		$company['groupid'] = 6;
		$company_model = D('Company');
		$companyid = '';
		$companyid = $company_model->addCompany($company);
		if(!$companyid)
		{
			return array('code'=>0,'message'=>$company_model->error);
		}
	    
		return array('code'=>1,'message'=>L('ADMIN_ADD').L('ADMIN_SUCCESS'));
	}
	/**
	* @: 修改Company表中数据
	*/
	private function updateCompanyData($company = array(),$distributor = array(),$companyid = '')
	{
		$error = '';
		//查询公司数据
		$company_model = D('Company');
		$company_info = '';
		$company_info = $company_model->getCompany($companyid);
		if(!$company_info)
		{
			return array('code'=>0,'message'=>L('COMPANY').L('ADMIN_NOEXISTED'));
		}
		$old_distributorids = explode(',',$company_info['distributorids']);
		/*分离经销商的数据,增,删,改*/
		$distributor_model = D('CompanyDistributor');
		$save_key = array();
		$dele_key = array();
		$new_key  = array();
		foreach ($distributor as $key => $value){
			$tmp = '';
			if(!empty($old_distributorids) and in_array($key,$old_distributorids))//修改
			{
				$distributor_model->updateDistributor($value,$key);
				$save_key[]  = $key;
			}else{
				$tmp = $distributor_model->checkDistributor($value);
				if($tmp)//存在返回id
				{
					$new_key[] = $tmp['distributorid'];
				}else{//不存在新增
					$new_id = '';
					$new_id = $distributor_model->addDistributor($value);
					if($new_id)
					{
						$new_key[] = $new_id;
					}
				}
			}
		}
		$new_dis_ids = '';
		$new_dis_ids = array_merge($save_key,$new_key);
		$new_dis_ids = array_unique($new_dis_ids);
		if(!empty($new_dis_ids))
		{
			$new_dis_ids = implode(',',$new_dis_ids);
		}
		$company['distributorids'] = $new_dis_ids;
		$company_model->updateCompany($company,$companyid);
		$dele_key = array_diff($old_distributorids,$save_key);
		foreach ($dele_key as $key => $value) {
			$distributor_model->deleteDistributor($value);
		}
		return array('code'=>1,'message'=>L('ADMIN_UPDATE').L('ADMIN_SUCCESS'));
	}
}