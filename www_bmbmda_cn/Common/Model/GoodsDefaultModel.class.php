<?php
namespace Common\Model;
use \Think\Model;
/**
 * 品牌模型model
 * @package sample
 * @subpackage classes
 */
class GoodsDefaultModel extends Model
{
	public $error = '';
	protected $tableName = 'goods_default_para';
	static $defaultvalue = 'goods_default_value';
	/**
	*功能：获取参数名列表
	*@param array $where
	*@param int $p 起始页
	*@param int $size 每页显示条数
	*@param string $order 排序
	*@return false | array数据和分页
	**/
	public function getDefaultParamList($where = array('1'),$p = 0,$size = 20,$order = 'dparaid DESC')
	{
		$data = array();
		$M_param = M($this->tableName);
		$count = $M_param->where($where)->count();
        $pages = pages($count,$p,$size);
        $result = $M_param->where($where)->page($p,$size)->order($order)->select();
        $data['data'] = $result;
        $data['page'] = $pages;
		return $data;
	}
	/**
	*功能：添加和修改默认参数
	*@param array $data
	*@return false | dparaid
	**/
	public function addDefaultParam($data = array())
	{
		$M_param = M($this->tableName);
		if(empty($data['catid']))
		{
			$this->error = L('ADMIN_CAT').L('ADMIN_NOTEMPTY');
			return false;
		}
		if(empty($data['param']))
		{
			$this->error = L('ADMIN_PARAMETER').L('ADMIN_NOTEMPTY');
			return false;
		}
		//检查是否存在
		$info = array();
		$info = $M_param->where(array('catid'=>$data['catid'],'param'=>$data['param']))->find();

		$dparaid = '';
		if(empty($data['dparaid']))
		{
			if(!empty($info))
			{
				$this->error = L('ADMIN_PARAMETER').L('ADMIN_EXISTED');
				return false;
			}
			return $M_param->add($data);
		}else{
			if(!empty($info) and $info['dparaid'] != $data['dparaid'])
			{
				$this->error = L('ADMIN_PARAMETER').L('ADMIN_EXISTED');
				return false;
			}
			$dparaid = $data['dparaid'];
			unset($data['dparaid']);
			return $M_param->where(array('dparaid'=>$dparaid))->save($data);
		}
	}
	/**
	*功能：根据dparaid获取默认参数
	*@param int $dparaid
	*@return array
	**/
	public function getDefaultParam($dparaid = 0)
	{
		return M($this->tableName)->where(array('dparaid'=>$dparaid))->find();
	}
	/**
	*功能：根据dparaid获取默认参数值
	*@param int $dparaid
	*@return array
	**/
	public function getGoodsDefaultValue($dparaid = 0)
	{
		return M(self::$defaultvalue)->where(array('dparaid'=>$dparaid))->select();
	}
	/**
	*功能：添加和修改默认参数值
	*@param array $data
	*@return false | dvid
	**/
	public function addDefaultValue($data = array())
	{
		$M_value = M(self::$defaultvalue);
		if(empty($data['value']))
		{
			$this->error = L('ADMIN_PARAMETER').L('ADMIN_VALUE').L('ADMIN_NOTEMPTY');
			return false;
		}
		if(empty($data['dparaid']))
		{
			$this->error = L('ADMIN_PARAMETER').L('ADMIN_NOTEMPTY');
			return false;
		}
		$data['value'] = strtolower($data['value']);
		//检查是否存在
		$info = array();
		$info = $M_value->where(array('dparaid'=>$data['dparaid'],'value'=>$data['value']))->find();
		$dparaid = '';
		if(empty($data['dvid']))
		{
			if(!empty($info))
			{
				$this->error = L('ADMIN_PARAMETER').L('ADMIN_VALUE').L('ADMIN_EXISTED');
				return false;
			}
			return $M_value->add($data);
		}else{
			if(!empty($info) and $info['dvid'] != $data['dvid'])
			{
				$this->error = L('ADMIN_PARAMETER').L('ADMIN_VALUE').L('ADMIN_EXISTED');
				return false;
			}
			return $M_value->save($data);
		}
	}
	
}