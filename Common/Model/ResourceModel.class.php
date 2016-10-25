<?php
namespace Common\Model;
use \Think\Model;
/**
 * 资源模型model
 * @package sample
 * @subpackage classes
 */
class ResourceModel extends Model
{
	public $error = '';
    /**
     * 功能：添加资源
     * @param array $data 添加数据
     * @return false | $resid 资源id
     */
	public function addResource($data = array())
	{
		if(empty($data)) return false;
		//名称
		if(empty($data['res_name']))
		{
			$this->error = L('RESOURCE').L('ADMIN_NAME').L('ADMIN_NOTEMPTY');
			return false;
		}
		// 类型
		if(empty($data['res_type']))
		{
			$this->error = L('RESOURCE').L('ADMIN_TYPE').L('ADMIN_NOTEMPTY');
			return false;
		}
		// 地址
		if(empty($data['resource']))
		{
			$this->error = L('RESOURCE').L('ADMIN_NOTEMPTY');
			return false;
		}
		$data = $this->dealResourceData($data);
		$resid = '';
		$resid = $this->add($data);
		if($resid)
		{
			return $resid;
		}else{
			$this->error = L('RESOURCE').L('ADMIN_ADD').L('ADMIN_FAILED');
			return false;
		}
	}
	/**
     * 功能：修改资源
     * @param array $data 添加数据
     * @param int $resid 资源id
     * @return false | $resid 资源id
     */
	public function updateResource($data = array(),$resid = 0)
	{
		$data = $this->dealResourceData($data);
		$resid = intval($resid);
		if(empty($data) or $resid <= 0) return false;
        //验证资源是否存在
		$info = '';
		$info =  $this->getResource($resid);
		if(!$info)
		{
			$this->error = L('RESOURCE').L('ADMIN_NOEXISTED');
			return false;
		}
		//修改
		$rs = '';
		$rs = $this->where(array('resid'=>$resid))->save($data);
		if($rs)
		{
			return $resid;
		}else{
			$this->error = L('RESOURCE').L('ADMIN_UPDATE').L('ADMIN_FAILED');
			return false;
		}
	}
	/**
     * 功能：处理资源原始数据
     * @param array $data 添加数据
     * @return false | $data 处理后的数据
     */
	private function dealResourceData($data = array())
	{
		if(empty($data)) return false;
		//名称
		if(!empty($data['res_name']))
		{
			$res_name = get_substr($data['res_name'],150);
			if(!$res_name)
			{
				$this->error =  L('RESOURCE').L('LONGER_THAN').'150';
				return false;
			}
			$data['res_name'] = $res_name;
		}
        //类型
		if(!empty($data['res_type']))
		{
			$res_type = preg_replace("/[\s]+/i"," ",$data['res_type']);
			$res_type = get_substr($res_type,30);
			if(!$res_type)
			{
				$this->error =  L('RESOURCE').L('ADMIN_TYPE').L('LONGER_THAN').'30';
				return false;
			}
			$data['res_type'] = $res_type;
		}
		//资源
		if(!empty($data['resource']))
		{
			$resource = get_substr($data['resource'],255);
			if(!$resource)
			{
				$this->error =  L('RESOURCE').L('LONGER_THAN').'255';
				return false;
			}
			$data['resource'] = $resource;
		}
		return $data;
	}
    /**
     * 功能：根据id获取资源数据
     * @param int $resid 资源id
     * @return false | array 资源信息
     */
	public function getResource($resid = 0)
	{
		$resid = intval($resid);
		if($resid <= 0) return false;
		return $this->where(array("resid"=>$resid))->find();
	}
	/**
     * 功能：根据id删除资源数据
     * @param int $resid 资源id
     * @return false | true 
     */
	public function deleteResource($resid = 0)
	{
		$resid = intval($resid);
		if($resid <= 0) return false;
		$info = '';
		$info = $this->getResource($resid);
		if(!$info)
		{
			$this->error = L('RESOURCE').L('ADMIN_NOEXISTED');
			return false;
		}
		return $this->where(array("resid"=>$resid))->delete();
	}
}