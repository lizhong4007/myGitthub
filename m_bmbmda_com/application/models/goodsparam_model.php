<?php
class Goodsparam_model extends MY_Model{
	static $goodsvalue_table = 'goods_value';
	static $goodsparam_table = 'goods_param';
	function __construct(){
		parent::__construct();
    }
	/**
	 * 根据商品id获取该商品的参数名和参数值
	 * @param  int $goodsid
	 * @return false | array
	 * @throws Exception
	 */
	public function getGoodsParameter($goodsid = 0)
	{
		$data = array();
		$goodsid = intval($goodsid);
		if($goodsid <= 0)
		{
			return $data ;
		}
		$goods_value = $this->getValueByGoodsid($goodsid);
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
		$param = $this->getGoodsParamData($paraids);


		$has_inner = array('0'=>'No','1'=>'Yes');//有无内胎
		$huawen = array('0'=>'-','1'=>'Symmetric','2'=>'asymmetric','3'=>'Single guide','4'=>'Double guide');//花纹
		foreach ($param as $key => $value) {
			if(strcmp(strval($value['paraid']), '40') == 0)
			{
				$param_tmp[$value['paraid']]['value'] = $has_inner[$param_tmp[$value['paraid']]['value']];
			}
			if(strcmp(strval($value['paraid']), '41') == 0)
			{
				$param_tmp[$value['paraid']]['value'] = $huawen[$param_tmp[$value['paraid']]['value']];
			}
			$tmp = array();
			$tmp['paraid'] = $value['paraid'];
			$tmp['param'] = $value['param'];
			$tmp['param_alias'] = $value['param_alias'];
			if(!empty($param_tmp[$value['paraid']]['vid']))
			{
				$tmp['vid'] = $param_tmp[$value['paraid']]['vid'];
			}else{
				$tmp['vid'] = '';
			}

			if(!empty($param_tmp[$value['paraid']]['value']))
			{
				$tmp['value'] = $param_tmp[$value['paraid']]['value'];
			}else{
				$tmp['value'] = '';
			}
			$data[] = $tmp; 
		}
		return $data;
	}

	/**
     * 功能：根据goodsid查询参数值
     * @param int $goodsid 
     * @return false | array 
     */
	public function getValueByGoodsid($goodsid = 0)
	{
		$goodsid = intval($goodsid);
		$data = array();
		$data = $this->db->get_where('goods_value',array('goodsid'=>$goodsid))->result_array();
		return $data;
	}

	/**
     * 功能：根据id查询多条参数名
     * @param int $paraids 
     * @return false | array 
     */
	public function getGoodsParamData($paraids = array())
	{
		$data = array();
		if(empty($paraids))
		{
			return array();
		}
		if(!is_array($paraids))
		{
			$paraids = array(intval($paraids));
		}
		$data = $this->db->select('*')->from(self::$goodsparam_table)->where_in('paraid',$paraids)->get()->result_array();
		return $data;
	}
}