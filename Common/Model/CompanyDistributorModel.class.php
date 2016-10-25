<?php
namespace Common\Model;
use \Think\Model;
/**
 * 经销商模型model
 * @package sample
 * @subpackage classes
 */
class CompanyDistributorModel extends Model
{
	public $error = '';
	static $distributor_table = 'company_distributor';
	/**
	*功能：获取经销商列表
	*@param array $where
	*@param int $p 起始页
	*@param int $size 每页显示条数
	*@param string $order 排序
	*@return false | array数据和分页
	**/
	public function getCompanyDistributorList($where = array('1'),$p = 0,$size = 20,$order = 'distributorid DESC')
	{
		$data = array();
		$count = $this->where($where)->count();
        $pages = pages($count,$p,$size);
        $result = $this->where($where)->page($p,$size)->order($order)->select();
        $data['data'] = $result;
        $data['page'] = $pages;
		return $data;
	}

	/**
	*功能：添加经销商
	*@param array $data
	*@return false | distributorid
	**/
	public function addDistributor($data = array())
	{
		if(empty($data)) return false;
		//省和详细地址不能为空
		if(empty($data['provinceid']))
		{
			$this->error = L('ADMIN_PROVINCE').L('ADMIN_NOTEMPTY');
			return false;
		}
		if(empty($data['address']))
		{
			$this->error = L('DEAIL_ADDRESS').L('ADMIN_NOTEMPTY');
			return false;
		}
		//检查数据
		$check = '';
		$check = $this->checkDistributor($data);
		if($check)
		{
			$this->error = L('DISTRIBUTOR').L('ADMIN_EXISTED');
			return false;
		}
		//处理数据
		$data = $this->dealDistributor($data);
		if(!$data)
		{
			return false;
		}
		if(isset($data['distributorid']))
		{
			unset($data['distributorid']);
		}
		$distributorid = '';
		$distributorid = $this->add($data);
		if($distributorid)
		{
			return $distributorid;
		}else{
			$this->error = L('ADMIN_ADD').L('ADMIN_FAILED');
			return false;
		}		
	}
    /**
	*功能：获取单条经销商信息
	*@param array $where
	*@return false | array
	**/
	public function getDistributor($distributorid = 0)
	{
		$distributorid = intval($distributorid);
		if($distributorid <= 0) return false;
		return $this->where(array("distributorid"=>$distributorid))->find();
	}
	/**
	*功能：获取多条经销商信息
	*@param array $where
	*@param string $order
	*@return false | array
	**/
	public function getDistributorData($where = array(),$order = '`distributorid` ASC')
	{
		if(empty($where)) return false;
		return $this->where($where)->order($order)->select();
	}
    /**
	*功能：根据distributorid修改经销商信息
	*@param array $data
	*@param int $distributorid
	*@return false | distributorid
	**/
	public function updateDistributor($data = array(),$distributorid = 0)
	{
		$distributorid = intval($distributorid);
		if(empty($data) or $distributorid <= 0) return false;
		//验证经销商是否存在
		$info = '';
		$info = $this->checkDistributor($data);
		if($info)
		{
			if($distributorid != $info['distributorid'])
			{
				$this->error = L('DISTRIBUTOR').L('ADMIN_EXISTED');
				return false;
			}
		}
		//处理数据
		$data = $this->dealDistributor($data);
		if(isset($data['distributorid']))
		{
			unset($data['distributorid']);
		}
		$rs = '';
		$rs = $this->where(array('distributorid'=>$distributorid))->save($data);
		if($rs)
		{
			return $distributorid;
		}else{
			$this->error = L('DISTRIBUTOR').L('ADMIN_UPDATE').L('ADMIN_FAILED');
			return false;
		}
	}
	/**
	*功能：根据distributorid修改经销商信息
	*@param int $distributorid
	*@return false | 1(true)
	**/
	public function deleteDistributor($distributorid = 0)
	{
		$distributorid = intval($distributorid);
		if($distributorid <= 0) return false;
		//查询公司中是否有经销商，查到不删除
		$company = '';
		$company = D('Company')->getCompanyData(array('_string'=>'FIND_IN_SET("'.$distributorid.'",`distributorids`)'));
		if($company)
		{
			$this->error = L('NOT_ALLOW').L('ADMIN_DELETE');
			return false;
		}
		$result = '';
		$result = $this->where(array('distributorid'=>$distributorid))->delete();
		if($result)
		{
			return $result;
		}else{
			$this->error = L('ADMIN_DELETE').L('ADMIN_FAILED');
			return false;
		}
	}
	
	/**
	 *功能：处理经销商数据
	 *@param: array $distributor 经销商数据
	 *@return false | array //处理后的数据
	 */
    private function dealDistributor($distributor = array())
    {
    	if(empty($distributor))  return false;
    	//基本数据
    	if(!empty($distributor['distributor_name']))
    	{
    		$distributor['distributor_name'] = get_substr($distributor['distributor_name'], 255);
    		if(!$distributor['distributor_name'])
    		{
    			$this->error = L('DISTRIBUTOR').L('LONGER_THAN').'255';
    			return false; 
    		}
    	}
    	$site = '';
		if(!empty($distributor['site']))
		{
			$site = $distributor['site'];
			if(!preg_match("/[http|https]:\/\//i",$site))
			{
				$this->error = L('CHECK_SITE');
				return false;
			}
		}
		if(!empty($distributor['address']))
		{
			$distributor['address'] = get_substr($distributor['address'], 255);
    		if(!$distributor['address'])
    		{
    			$this->error = L('DEAIL_ADDRESS').L('LONGER_THAN').'255';
    			return false; 
    		}
		}
        //telephone
		if(!empty($distributor['telephone']))
		{
			$distributor['telephone'] = $this->removeSpaces($distributor['telephone']);
		}
		//email
		if(!empty($distributor['email']))
		{
			$distributor['email'] = $this->removeSpaces($distributor['email'],150);
		}
		//contacts
		if(!empty($distributor['contacts']))
		{
    		$distributor['contacts'] = $this->removeSpaces($distributor['contacts'],100);
		}
		//qq
		if(!empty($distributor['qq']))
		{
			$distributor['qq'] = $this->removeSpaces($distributor['qq']);
		}
		//platform
		if(!empty($distributor['platform']))
		{
			$distributor['platform'] = $this->removeSpaces($distributor['platform']);
		}
		//account
		if(!empty($distributor['account']))
		{
			$distributor['account'] = $this->removeSpaces($distributor['account']);
		}
		return $distributor;
    }
    /**
     *功能：去除数组中的空格，并以逗号分割成字符串
     *@param array $data 待处理数组
     *@param int $length 返回字符串截取长度
     *@return $string 返回字符串
    */ 
    private function removeSpaces($data,$length = 255){
    	$string = '';
    	if(is_array($data))
    	{
    		foreach ($data as $key => $value) {
	    		if(empty($value))
	    		{
	    			unset($data[$key]);
	    		}
	    	}
    	    $string = implode(',', $data);
    	}else{
    		$string = $data;
    	}
    	$string = substr($string,0, $length);
    	return $string;
    }
    /**
	 *功能：验证经销商是否存在
	 *@param: array $data 经销商数据
	 *@return false | array //查询到的数据
	*/
    public function checkDistributor($data = array())
    {
    	if(empty($data)) return false;
    	$where = array();
    	$where['distributor_name'] = empty($data['distributor_name']) ? '' : $data['distributor_name'];
    	$where['address'] = $data['address'];
    	$where['provinceid'] = intval($data['provinceid']);
    	$where['cityid'] = intval($data['cityid']);
    	$where['areaid'] = intval($data['areaid']);
		$distributor_info = '';
		$distributor_info = $this->getDistributorData($where);
		if($distributor_info)
		{
			return array_pop($distributor_info);
		}else{
			return false;
		}
    }
}