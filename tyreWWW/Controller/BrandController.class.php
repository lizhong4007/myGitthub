<?php
namespace TyreWWW\Controller;
use Think\Controller;
class BrandController extends CommonController {

	/*商品列表*/
	public function brand_list(){
        
        $brand = array();
        $M_brand = D("Brands");
        $brandid = intval(I('brandid',''));
        $where = array();
        if(!empty($brandid))
        {
        	$brand[] = $M_brand->where(array('brandid'=>$brandid))->find();
        }else{
        	//品牌
			$brand = $M_brand->getAllBrand(array('is_recommend'=>1));

        }

        $brandids = array();
        foreach ($brand as $key => $value) {
        	$brandids[] = $value['brandid'];
        }

        $where['brandid'] = array('in',$brandids);

        $p = intval(I('p',1));
        $goods = array();
        $M_goods = D('Goods');
		$goods = $M_goods->getGoodsList($where,$p,20);
		//实例化商品参数
		$S_GoodsParam = D("GoodsParam","Service");
		$goods_data_tmp = array();
		foreach ($goods['data'] as $key => $value) {
			$tmp = array();
			$tmp = $S_GoodsParam->getGoodsParameter($value['goodsid']);
			$value['param'] = $tmp;
			$goods_data_tmp[] = $value;
		}


		$this->assign("brand",$brand);
		$this->assign("goods",$goods_data_tmp);
		$this->assign("page",$goods['page']);

		// print_r($goods['page']);exit;


		/*seo*/
		$seo = '<title>'.L('BRAND_ZONE').'-bmbmda.com</title>';
		$seo .= '<meta name="keywords" content="米其林 邓禄普 '.L('BRAND_ZONE').' 轮胎品牌 轮胎" />';
		$seo .= '<meta name="description" content="蹦蹦哒'.L('BRAND_ZONE').',各种各样的轮胎品牌" />';
		$seo .= '<link rel="canonical" href="'.$this->default_site.U('Brand/brand_list').'/'.$p.'" />';
		if(!empty($brandid))
		{
			$seo .= '<link rel="alternate" media="only screen and (max-width: 640px)" href="'.$this->default_mobile_site.U('Brand/brand_list',array('brandid'=>$brandid)).'" >';
		}
		$this->assign("seo",$seo);

		$this->display("Brand/brand_list");
	}

    /*根据品牌id获取商品*/
	public function get_brand_goods()
	{
        $brandid = intval(I('brandid',''));
        $where = array();

        $where['brandid'] = $brandid;

        $p = intval(I('currentpage',1));
        $goods = array();
        $M_goods = D('Goods');
		$goods = $M_goods->getGoodsList($where,$p,20);
        
        //实例化商品参数
		$S_GoodsParam = D("GoodsParam","Service");
		$goods_data_tmp = array();
		foreach ($goods['data'] as $key => $value) {
			$tmp = array();
			$tmp = $S_GoodsParam->getGoodsParameter($value['goodsid']);
			$str = '';
			foreach ($tmp as $k => $v) {
				$str .= '<li class="width300 ">';
				$str .= '<span>'.$v['param'].':</span>';
				$str .= $v['value'];
			    $str .= '</li>';
			}
			if(empty($value['minprice']) or $value['minprice'] == 0.00)
			{
				$value['minprice'] = '';
			}
			$value['param'] = $str;
			$value['goods_url'] = U('Goods/detail',array('goodsid'=>$value['goodsid']));
			$goods_data_tmp[] = $value;
		}

		echo json_encode(array('data'=>$goods_data_tmp,'totalrows'=>$goods['page']['totalRows']));
		exit();

	}
}