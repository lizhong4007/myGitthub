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
			$param_tmp[$value['paraid']] = array('value'=>$value['value'],'vid'=>$value['vid']);
		}
		$where = array();
		$where['paraid'] = array('in',$paraids);
		$param = $M_GoodsParam->getGoodsParamData($where);
		$has_inner = array('0'=>'无','1'=>'有');//有无内胎
		$huawen = array('0'=>'-','1'=>'对称','2'=>'非对称','3'=>'单导向','4'=>'双导向');//花纹
		foreach ($param as $key => $value) {
			if($value['paraid'] == 40)
			{
				$param_tmp[$value['paraid']]['value'] = $has_inner[$param_tmp[$value['paraid']]['value']];
			}
			if($value['paraid'] == 41)
			{
				$param_tmp[$value['paraid']]['value'] = $huawen[$param_tmp[$value['paraid']]['value']];
			}
			$data[] = array(
				'paraid'=>$value['paraid'],
				'param'=>$value['param'],
				'vid'=>$param_tmp[$value['paraid']]['vid'],
				'value'=>$param_tmp[$value['paraid']]['value'],
				); 
		}
		return $data;
	}
}