<?php
namespace Common\Model;
use \Think\Model;
/**
 * 产品检查模型model
 * @package sample
 * @subpackage classes
 */
class GoodsCheckModel extends Model
{
	public $error = '';
    /**
     * 功能：添加产品检查记录
     * @param array $data 添加数据
     * @return false | $goodsid 产品id
     */
	public function addGoodsCheck($data = array())
	{
		if(empty($data)) return false;
		//产品加密
		if(empty($data['stringmd5']))
		{
			$this->error = 'stringmd5 '.L('ADMIN_NOTEMPTY');
			return false;
		}
		// 产品id
		if(empty($data['goodsid']) or intval($data['goodsid']) <= 0)
		{
			$this->error = L('ADMIN_GOODS').' id '.L('ADMIN_NOTEMPTY');
			return false;
		}
		$id = '';
		$id = $this->add($data);
		if($id)
		{
			return $data['goodsid'];
		}else{
			$this->error = L('ADMIN_GOODS').L('ADMIN_CHECK').L('ADMIN_ADD').L('ADMIN_FAILED');
			return false;
		}
	}
	/**
     * 功能：根据产品MD5查询产品检查数据
     * @param string $stringmd5 
     * @return false | array 
     */
	public function getGoodsCheckByMd5($stringmd5 = '')
	{
		return $this->where(array('stringmd5'=>$stringmd5))->find();
	}
}