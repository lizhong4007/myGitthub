<?php
namespace Common\Model;
use \Think\Model;
/**
 * 系列模型model
 * @package sample
 * @subpackage classes
 */
class ModelCarsModel extends Model
{
	public $error = '';
	/**
	*功能：获取系列列表
	*@param array $where
	*@param int $p 起始页
	*@param int $size 每页显示条数
	*@param string $order 排序
	*@return false | array数据和分页
	**/
	public function getModelCarsList($where = array('1'),$p = 0,$size = 20,$order = 'id DESC')
	{
		$data = array();
		$count = $this->where($where)->count();
        $pages = pages($count,$p,$size);
        $result = $this->where($where)->page($p,$size)->order($order)->select();
        $data['data'] = $result;
        $data['page'] = $pages;
		return $data;
	}
}