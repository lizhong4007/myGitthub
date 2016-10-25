<?php
namespace Common\Model;
use \Think\Model;
/**
 * 公司模型model
 * @package sample
 * @subpackage classes
 */
class CompanyModel extends Model
{
	public $error = '';
	
	/**
	*功能：获取公司列表
	*@param array $where
	*@param int $p 起始页
	*@param int $size 每页显示条数
	*@param string $order 排序
	*@return false | array数据和分页
	**/
	public function getCompanyList($where = array('1'),$p = 0,$size = 20,$order = 'companyid DESC')
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
	*功能：添加公司 可输出错误信息
	*@param array $data
	*@return false | companyid
	**/
	public function addCompany($data = array())
	{
		if(empty($data)) return false;
		//公司名称
    	if(empty($data['company_name']))
    	{
    		$this->error = L('COMPANY').L('ADMIN_NOTEMPTY');
    		return false;
    	}
    	if(empty($data['company_alias']))
    	{
    		$this->error = L('COMPANY').L('ADMIN_LANGUAGE_NAME').L('ADMIN_NOTEMPTY');
    		return false;
    	}
    	//mode经营模式
		if(empty($data['operation_mode']))
    	{
    		$this->error = L('MANAGEMENT_MODEL').L('ADMIN_NOTEMPTY');
	    	return false;
    	}
    	//网址
		$site = array();	    
	    if(empty($data['site']))
	    {
	    	$this->error = L('ADMIN_SITE').L('ADMIN_NOTEMPTY');
	    	return false;
	    }
	    $data = $this->dealCompany($data);
	    if(!$data)
	    {
	    	return false;
	    }
	    //检查公司
	    $info = '';
	    $info = $this->checkCompany($data);
	    if($info)
	    {
	    	return false;
	    }
	    //域名唯一
		$check_domain = '';
		$check_domain = $this->getCompanyData(array('domain'=>$data['domain']));
		if($check_domain)
		{
			$this->error = L('COMPANY').L('ADMIN_EXISTED');
	    	return false;
		}
		$data['addtime'] = TIMESTAMP;
		//添加
		$companyid = '';
		$companyid = $this->add($data);
		if($companyid)
		{
			return $companyid;
		}else{
			$this->error = L('COMPANY').L('ADMIN_ADD').L('ADMIN_FAILED');
			return false;
		}
	}
	/**
	*功能：修改公司
	*@param array $data
	*@param int $companyid
	*@return false | companyid
	**/
	public function updateCompany($data = array(),$companyid = 0)
	{
		$companyid = intval($companyid);
		if(empty($data) or $companyid <= 0) return false;
		//检查数据
		$info = '';
		$info = $this->getCompany($companyid);
		if(!$info)
		{
			$this->error = L('COMPANY').L('ADMIN_NOEXISTED');
	    	return false;
		}
		//处理数据
		$data = $this->dealCompany($data);
		if(!$data)
		{
			return false;
		}
		//检查公司
		$company = '';
		$company = $this->checkCompany($data);
		if($company)
		{
			if(count($company) > 1 or $company[0]['companyid'] != $companyid)
			{
				$this->error = L('COMPANY').L('ADMIN_EXISTED');
		    	return false;
			}
		}
		//域名唯一
		$check_domain = '';
		$check_domain = $this->getCompanyData(array('domain'=>$data['domain']));
		if($check_domain)
		{
			if($check_domain[0]['companyid'] != $companyid)
			{
				$this->error = L('COMPANY').L('ADMIN_EXISTED');
	    	    return false;
	    	}
		}
		//修改
		$result = '';
		$result = $this->where(array('companyid'=>$companyid))->save($data);
		if($result)
		{
			return $companyid;
		}else{
			$this->error = L('COMPANY').L('ADMIN_EDIT').L('ADMIN_FAILED');
			return false;
		}
	}
	/**
	*功能：根据公司id获取单条公司信息
	*@param int $companyid
	*@return false | array 
	**/
	public function getCompany($companyid = 0)
	{
		$companyid = intval($companyid);
		if($companyid <= 0) return false;
		return $this->where(array("companyid"=>$companyid))->find();
	}
	/**
	*功能：获取多条公司信息
	*@param array $where
	*@return false | array 
	**/
	public function getCompanyData($where = array())
	{
		if(empty($where)) return false;
		return $this->where($where)->select();
	}
	/**
	*功能：根据公司id删除公司
	*@param int $companyid
	*@return false | array 
	**/
	public function deleteCompany($companyid = 0)
	{
		if($companyid <= 0) return false;
		//检查是否有该公司
		$company = '';
		$company = $this->getCompany($companyid);
		if(!$company)
		{
			$this->error = L('COMPANY').L('ADMIN_NOEXISTED');
			return false;
		}
	    //商品表是否有该公司数据
	    $goods = '';
	    $goods = D('Goods')->getGoodsData(array("companyid"=>$companyid));
	    if($goods)
	    {
	    	$this->error = L('ADMIN_NOT').L('ADMIN_DELETE').L('ADMIN_PERMISSION');
	    	return false;
	    }
	    $rs = $this->where(array("companyid"=>$companyid))->delete();
	    if($rs)
	    {
	    	//删除经销商公司id
	    	D("CompanyDistributor")->updateDistributorCompanyids($companyid);
	    	return $rs;
	    }else{
	    	return false;
	    }
	}
	/**
	*功能：根据名称查询公司是否存在
	*@param array $data
	*@return false | array 
	**/
	private function checkCompany($data = array())
	{
		if(empty($data)) return false;
		//组合条件
		$where = array();
		$where['company_name']  = $data['company_name'];
		$where['company_alias'] = $data['company_alias'];
		$where['_logic'] = 'or';
		$company = '';
		$company = $this->getCompanyData($where);
		if($company)
		{
			return $company;
		}else{
			return false;
		}
	}
	/**
	*功能：处理公司数据
	*@param array $data 
	*@return array $data
	**/
	private function dealCompany($data = array())
	{
		if(empty($data)) return false;
		if(!empty($data['company_name']))//中文名
		{
			$data['company_name'] = get_substr($data['company_name'], 255);
    		if(!$data['company_name'])
    		{
    			$this->error = L('COMPANY').L('LONGER_THAN').'255';
	    		return false;
    		}
		}
		if(!empty($data['company_alias']))//英文名
		{
			$company_alias = '';
			$company_alias = get_substr($data['company_alias'], 150);
			$data['company_alias'] = $company_alias;
			//company_short公司缩写名
			$data['company_short'] = $this->dealCompanyShortField($company_alias);
			//linkurl
			$linkurl = preg_replace("/[^a-zA-Z0-9]+/","-",$company_alias);
			$linkurl = preg_replace("/(-)+/i","-",$linkurl);
			$data['linkurl'] = $linkurl;
		}
		if(!empty($data['operation_mode']))//经营模式
		{
			if(is_array($data['operation_mode']))
            {
                $data['operation_mode'] = implode(',',$data['operation_mode']);
            }
		}
		if(!empty($data['site']))
	    {
	    	$site = $this->dealSiteField($data['site']);
	    	if($site['code'] == 0)
	    	{
	    		$this->error = $site['message'];
	    	    return false;
	    	}else{
	    		$data['site'] = $site['site'];
	    		$data['domain'] = $site['domain'];
	    	}
	    }
	    if(isset($data['companyid']))//不修改数据
		{
			unset($data['companyid']);
		}
		return $data;
	}
	/**
	*功能：处理公司site网址
	*从中获取域名，主域名唯一
	*@param string $site 网址
	*@return array $data 网址和域名 错误标记code
	**/
	private function dealSiteField($site = '')
	{
		if($site == '')
		{
			return array('code'=>0,'message'=>L('ADMIN_SITE').L('ADMIN_NOTEMPTY'));
		}
		$data = array();
		if(!preg_match("/[http|https]:\/\//i",$site))
		{
			return array('code'=>0,'message'=>L('CHECK_SITE'));
		}
		$host = '';
		$host = parse_url($site);
		if($host){
			$host = $host['host'];
		}else{
			return array('code'=>0,'message'=>L('SITE_NOT_NEED'));
		}
		//域名
		if(!preg_match("/[a-z0-9\-]{1,63}\.[a-z\.]{2,6}$/",$host , $domain)){
			return array('code'=>0,'message'=>L('SITE_NOT_NEED'));
		}
		return array('code'=>1,'site'=>$site,'domain'=>$domain[0]);
	}
	/**
	*功能：处理公司company_short缩略名字段
	*缩略名是唯一的
	*@param string $company_short 缩略名
	*@param int $length 表字段长度
	*@return $company_short 
	**/
	private function dealCompanyShortField($company_short = '',$length = 30)
	{
    	$company_short = preg_replace("/[^a-zA-Z0-9]+/"," ",$company_short);
		if(strlen($company_short) < $length){
			$company_short = preg_replace("/[\s]+/","",trim($company_short));
		}else{
			$tmp_company_short = '';
			foreach(explode(" ",$company_short) as $value){
				$tmp_company_short .= strtolower(substr($value,0,1));
			}
			$company_short = $tmp_company_short;
			if(strlen($company_short) > $length){
				$company_short = substr($company_short,0,$length);
			}
		}
		$company_short = $this->getUniqueShortName($company_short);
		return $company_short;
	}

	/**
	*功能：生成公司唯一缩写名$company_short
	*@param string $company_short
	*@return false | string 
	**/
	private function getUniqueShortName($company_short = '')
	{
		$company_short = trim($company_short);
		if($company_short == '') return false;
		//截取名字
        $company_short = substr($company_short,0,30);
        //验证company_short
        $info = '';
        $info = $this->getCompanyData(array('company_short'=>$company_short));
        if(!$info)
        {
            return $company_short;
        }else{//生成新的company_short
            $lengthgth = '';
            $lengthgth = strlen($company_short);
            if($lengthgth>30)
            {
                $company_short = substr($company_short,0,24);
            }
            $str = null;
            $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
            $max = strlen($strPol)-1;
            for($i = 0;$i < 6;$i++){
                $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
            }
            $company_short = $company_short.$str;
            return $this->getUniqueShortName($company_short);
        }
	}
}