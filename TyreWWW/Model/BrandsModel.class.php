<?php
namespace TyreWWW\Model;
use \Think\Model;
/**
 * 品牌模型model
 * @package sample
 * @subpackage classes
 */
class BrandsModel extends Model
{
	protected $tableName = 'brand';
	/**
	 *功能：获取所有品牌数据，
	 *@param string $order
	 *@return  array 
	*/
	public function getAllBrand($where = array(),$order = 'is_recommend DESC')
	{
		return $this->where($where)->order($order)->select();
	}
}