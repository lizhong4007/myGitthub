<?php
namespace Common\Model;
use \Think\Model;
/**
 * 产品规格参数值模型model
 * @package sample
 * @subpackage classes
 */
class GoodsValueModel extends Model
{
	public $error = '';
    /**
     * 功能：添加产品规格参数值
     * @param array $data 添加数据
     * @return false | $goodsid 产品id
     */
	public function addGoodsValue($data = array())
	{
		if(empty($data)) return false;
		//产品加密
		if(empty($data['value']))
		{
			$this->error = L('ADMIN_SPEC').L('ADMIN_NOTEMPTY');
			return false;
		}else{
			$data['param'] = trim(substr($data['value'],0,255));
		}
		if(empty($data['paraid']))
		{
			$this->error = L('ADMIN_SPEC').L('ADMIN_NAME').L('ADMIN_NOTEMPTY');
			return false;
		}
		if(empty($data['goodsid']))
		{
			$this->error = L('ADMIN_GOODS').L('ADMIN_TITLE').L('ADMIN_NOTEMPTY');
			return false;
		}
		//检查参数值是否存在
		$value = '';
		$value = $this->checkGoodsValue($data);
		if($value)
		{
			$this->error = L('ADMIN_SPEC').L('ADMIN_EXISTED');
			return false;
		}
		$vid = '';
		$vid = $this->add($data);
		if($vid)
		{
			return $vid;
		}else{
			$this->error = L('ADMIN_SPEC').L('ADMIN_ADD').L('ADMIN_FAILED');
			return false;
		}
	}
	/**
     * 功能：检查参数值是否存在
     * @param array $data 
     * @return false | array 
     */
	public function checkGoodsValue($data = array())
	{
		$where = array();
		$where['paraid'] = $data['paraid'];
		$where['goodsid'] = $data['goodsid'];
		$where['value'] = $data['value'];
		$info = '';
		$info = $this->where($where)->select();
		if($info)
		{
			return array_pop($info);
		}else{
			return false;
		}
	}
	/**
     * 功能：查询多条参数值
     * @param array $where 
     * @return false | array 
     */
	public function getGoodsValueData($where = array())
	{
		return $this->where($where)->select();
	}
	/**
     * 功能：根据id查询参数值
     * @param int $vid 
     * @return false | array 
     */
	public function getGoodsValue($vid = 0)
	{
		$vid = intval($vid);
		return $this->where(array('vid'=>$vid))->find();
	}
	/**
     * 功能：根据goodsid查询参数值
     * @param int $goodsid 
     * @return false | array 
     */
	public function getValueByGoodsid($goodsid = 0)
	{
		$goodsid = intval($goodsid);
		return $this->where(array('goodsid'=>$goodsid))->select();
	}
}