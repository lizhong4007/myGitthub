<?php
namespace Common\Model;
use \Think\Model;
/**
 * 产品规格参数名模型model
 * @package sample
 * @subpackage classes
 */
class GoodsParamModel extends Model
{
	public $error = '';
    /**
     * 功能：添加产品规格参数名
     * @param array $data 添加数据
     * @return false | $goodsid 产品id
     */
	public function addGoodsParam($data = array())
	{
		if(empty($data)) return false;
		//产品加密
		if(empty($data['param']))
		{
			$this->error = L('ADMIN_SPEC').L('ADMIN_NAME').L('ADMIN_NOTEMPTY');
			return false;
		}else{
			$data['param'] = trim(substr($data['param'],0,255));
		}
		$param = array();
		$param = $this->getGoodsParamByName($data['param']);
		if($param)
		{
			$this->error = L('ADMIN_SPEC').L('ADMIN_NAME').L('ADMIN_EXISTED');
			return $param['paraid'];
		}
		$paraid = '';
		$paraid = $this->add($data);
		if($paraid)
		{
			return $paraid;
		}else{
			$this->error = L('ADMIN_SPEC').L('ADMIN_ADD').L('ADMIN_FAILED');
			return false;
		}
	}
	/**
     * 功能：根据参数名查询
     * @param string $param 
     * @return false | array 
     */
	public function getGoodsParamByName($param = '')
	{
		return $this->where(array('param'=>$param))->find();
	}
	/**
     * 功能：根据id查询参数名
     * @param int $paraid 
     * @return false | array 
     */
	public function getGoodsParam($paraid = 0)
	{
		$paraid = intval($paraid);
		return $this->where(array('paraid'=>$paraid))->find();
	}
	/**
     * 功能：根据id查询多条参数名
     * @param int $paraid 
     * @return false | array 
     */
	public function getGoodsParamData($where = array())
	{
		return $this->where($where)->select();
	}
}