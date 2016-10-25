<?php
namespace Common\Model;
use \Think\Model;
/**
 * 资源检查模型model
 * @package sample
 * @subpackage classes
 */
class ResourceCheckModel extends Model
{
	public $error = '';
    /**
     * 功能：添加资源检查记录
     * @param array $data 添加数据
     * @return false | $resid 资源id
     */
	public function addResourceCheck($data = array())
	{
		if(empty($data)) return false;
		//资源地址
		if(empty($data['resource']))
		{
			$this->error = L('RESOURCE').L('ADMIN_NOTEMPTY');
			return false;
		}
		// 地址加密
		$data['stringmd5'] = md5($data['resource']);
		// 地址
		if(empty($data['resid']) or intval($data['resid']) <= 0)
		{
			$this->error = L('RESOURCE').' id '.L('ADMIN_NOTEMPTY');
			return false;
		}
		$id = '';
		$id = $this->add($data);
		if($id)
		{
			return $data['resid'];
		}else{
			$this->error = L('RESOURCE').L('ADMIN_CHECK').L('ADMIN_ADD').L('ADMIN_FAILED');
			return false;
		}
	}
	/**
     * 功能：修改资源检查记录
     * @param array $data 添加数据
     * @param int $id 资源检查id
     * @return false | $resid 资源id
     */
	public function updateResourceCheck($data = array(),$id = 0)
	{
		$id = intval($id);
		if(empty($data) or $id <= 0) return false;
        //验证资源是否存在
		$info = '';
		$info =  $this->getResourceCheck($id);
		if(!$info)
		{
			$this->error = L('RESOURCE').L('ADMIN_NOEXISTED');
			return false;
		}
		//修改
		$rs = '';
		$rs = $this->where(array('id'=>$id))->save($data);
		if($rs)
		{
			return $id;
		}else{
			$this->error = L('RESOURCE').L('ADMIN_UPDATE').L('ADMIN_FAILED');
			return false;
		}
	}
    /**
     * 功能：根据id获取资源查看数据
     * @param int $resid 资源id
     * @return false | array 资源信息
     */
	public function getResourceCheck($id = 0)
	{
		$id = intval($id);
		if($id <= 0) return false;
		return $this->where(array("id"=>$id))->find();
	}
	/**
     * 功能：查询资源检查数据
     * @param array $where 
     * @return false | array 
     */
	public function getResourceCheckData($where = array())
	{
		return $this->where($where)->find();
	}
	/**
     * 功能：根据产品MD5查询资源检查数据
     * @param string $stringmd5 
     * @return false | array 
     */
	public function getResourceCheckByMd5($stringmd5 = '')
	{
		return $this->where(array('stringmd5'=>$stringmd5))->find();
	}
}