<?php
namespace Common\Service;
use \Think\Model;
/**
* Brand Service
*/
class GoodsParamService extends Model
{
	/**
	 * 根据商品id获取该商品的参数名和参数值
	 * @param  int $goodsid
	 * @return false | array
	 */
	public function getGoodsParameter($goodsid = 0)
	{
		$data = array();
		$goodsid = intval($goodsid);
		if($goodsid <= 0)
		{
			return $data ;
		}
		$M_GoodsValue = D('GoodsValue');
		$M_GoodsParam = D('GoodsParam');
		$goods_value = $M_GoodsValue->getValueByGoodsid($goodsid);
		if(empty($goods_value))
		{
			return $data;
		}
		$paraids = array();
		$param_tmp = array();
		foreach ($goods_value as $key => $value) {
			$paraids[] = $value['paraid'];
			$param_tmp[$value['paraid']] = $value['value'];
		}
		$where = array();
		$where['paraid'] = array('in',$paraids);
		$param = $M_GoodsParam->getGoodsParamData($where);
		
		foreach ($param as $key => $value) {
			$data[$value['param']] = $param_tmp[$value['paraid']];
		}
		return $data;
	}
}