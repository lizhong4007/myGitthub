<?php
namespace tyreManage\Controller;
use Think\Controller;
/**
* @HQtag: Goods operation
*/
class GoodsController extends CommonController {
	/**
	* @HQtag: Goods List
	*/
    public function goodsList(){
        $searchData = trim(I('post.goodsname',''));
        // 商品
        $where = array();
        if(!empty($searchData))
        {
            $str = '';
            $this->assign('goodsname',$searchData);
            $str = "goodsid = "."'".$searchData."' or ";
            $searchData = "'%".$searchData."%'";
            $str .= "title like ".$searchData." or en_title like ".$searchData." or brand like ".$searchData." or model like ".$searchData;
            $where = $str;
        }
        $p = (int)I('p',1);
        $size = 20;
        $goodslist = D("Goods")->getGoodsList($where,$p,$size);
        $goods_data = $goodslist['data'];
        //实例化商品参数
        $S_GoodsParam = D("GoodsParam","Service");
        $goods_data_tmp = array();
        foreach ($goods_data as $key => $value) {
            $tmp = array();
            $tmp = $S_GoodsParam->getGoodsParameter($value['goodsid']);
            $value['param'] = $tmp;
            $goods_data_tmp[] = $value;
        }
        $this->assign("goods",$goods_data_tmp);
        $this->assign("page",$goodslist['page']);
        $this->display('Goods/GoodsList');
    }

    /**
    * @HQtag: Add Goods
    */
    public function addGoods(){
        $this->display('Goods/GoodsEdit');
    }
}