<?php
namespace Home\Controller;
use Think\Controller;
class EggController extends Controller {

	/*商品列表*/
	public function index(){
		/*$M_model = M('Goods_value');
		$model = $M_model->where(array('paraid'=>7))->select();
		foreach ($model as $key => $value) {
			$fuhe = '';
			$fuhe = $value['value'];//负荷
            $fuhe = preg_replace('/[^0-9\/]/', '', $fuhe);
            $fuhe_tmp = array();
            $fuhe_tmp['paraid'] = 5;
            $fuhe_tmp['value'] = $fuhe;
            $M_model->where(array('vid'=>$value['vid']))->save($fuhe_tmp);

            $weight = '';
            $weight = $value['value'];//负荷
            $weight = preg_replace('/[^a-zA-Z]/', '', $weight);
            $weight = strtoupper($weight);
            $info = '';
            $info = $M_model->where(array('paraid'=>6,'goodsid'=>$value['goodsid'],'value'=>$weight))->find();
            if(empty($info))
            {
            	$M_model->add(array('paraid'=>6,'goodsid'=>$value['goodsid'],'value'=>$weight));
            }
		}*/
		// echo $vid;echo "<br>";

	
/*$where['goodsid'] = array('in',$goodsid);
$model = $M_model->($where)->select();*/
// echo $M_model->_sql();
		// print_r($vid);
		/*$M_model = M('Series');
		$model = $M_model->select();
		foreach ($model as $key => $value) {
			$tmp = array();
			$str = '';
			$str = strtolower($value['linkurl']);
			$str = preg_replace('/[^a-z0-9]/', " ", $str);
			$str = trim($str);
			$str = preg_replace('/[^a-z0-9]/', "-", $str);
			$tmp['linkurl'] = $str;
			$M_model->where(array('seriesid'=>$value['seriesid']))->save($tmp);

		}*/

		/*$M_model = M('Goods');
		$M_content = M('GoodsContent');
		$model = $M_model->where(array('goodsid>434'))->select();
		foreach ($model as $key => $value) {
			$tmp = array();
			$tmp['goodsid'] = $value['goodsid'];
			$tmp['resource_url'] = 'http://www.dunlop.com.cn/products_detail_1284.html';
			$info = array();
			$info = $M_content->where($tmp)->find();
			if(!$info)
			{
				$M_content->add($tmp);
			}
		}*/

		print_r($model);


	}
}