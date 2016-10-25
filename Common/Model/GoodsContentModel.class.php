<?php
namespace Common\Model;
use \Think\Model;
/**
 * 产品内容模型model
 * @package sample
 * @subpackage classes
 */
class GoodsContentModel extends Model
{
	public $error = '';
    /**
     * 功能：添加产品内容
     * @param array $data 添加数据
     * @return false | $goodsid 产品id
     */
	public function addGoodsContent($data = array(),$goodsid = 0)
	{
		$goodsid = intval($goodsid);
		if(empty($data) or $goodsid <= 0) return false;
		//检查产品是否存在
		if(empty($goodsid))
		{
			$this->error = L('ADMIN_GOODS').L('ADMIN_NOTEMPTY');
			return false;
		}else{
			$goods = '';
			$goods = D('Goods')->getGoods($goodsid);
			if(!$goods)
			{
				$this->error = L('ADMIN_GOODS').L('ADMIN_NOEXISTED');
				return false;
			}
		}
		//检查产品内容是否存在，存在更新，不存在新增
		$info = '';
		$info = $this->getGoodsContent($goodsid);
		$rs = '';
		if($info)
		{
			if(isset($data['goodsid']))
			{
				unset($data['goodsid']);
			}
			$rs = $this->where(array('goodsid'=>$goodsid))->save($data);
		}else{
			$data['goodsid'] = $goodsid;
			$rs = $this->add($data);
		}
		return $rs;
	}
	/**
     * 功能：根据产品id获取产品内容
     * @param int $goodsid 
     * @return false | array 
     */
	public function getGoodsContent($goodsid = 0)
	{
		$goodsid = intval($goodsid);
		return $this->where(array('goodsid'=>$goodsid))->find();
	}
}