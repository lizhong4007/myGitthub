<?php
namespace TyreWWW\Controller;
use Think\Controller;
class HomePageController extends CommonController {
	public function index()
	{
		//分类
		$category = D('Category')->getCategoryList();
		$this->assign("category",$category);
		// 商品
		$where = array();
		$p = (int)I('p',1);
		$size = 64;
		
		$is_imporat = (int)I('ip','');
		if(!empty($is_imporat))
		{
			$where['is_import'] = $is_imporat;
		}
		$this->assign("ip",$is_imporat);

		$goodslist = D("Goods")->getGoodsList($where,$p,$size);
		$goods_data = $goodslist['data'];

		//实例化商品参数
		$S_GoodsParam = D("GoodsParam","Service");
		$goods_data_tmp = array();
		$paraid_tmp = array(21,22,24,25,26,27,28,29,30,31,32,33,38);
		foreach ($goods_data as $key => $value) {
			$tmp = array();
			$tmp = $S_GoodsParam->getGoodsParameter($value['goodsid']);
			foreach ($tmp as $p_k => $para_t) {
				if(in_array($para_t['paraid'], $paraid_tmp))
				{
					unset($tmp[$p_k]);
				}
			}
			$value['param'] = $tmp;
			$goods_data_tmp[] = $value;
		}
		$this->assign("goods_data",$goods_data_tmp);
		$this->assign("page",$goodslist['page']);

		//推荐
		$offet = rand(0,10000);
		$recommed_goods = M("Goods")->distinct(true)->field('seriesid,model,goodsid')->limit($offet,8)->select();
		$this->assign("recommed_goods",$recommed_goods);



		/*seo*/
		$seo = '<title>蹦蹦哒轮胎-bmbmda.com</title>';
		$seo .= '<meta name="keywords" content="轮胎 冬季胎  轿车轮胎 雪地 轮胎花纹 SUV 冬季  规格 四季胎  夏季胎 乘用车 花纹  型号  经销商  蹦蹦哒" />';
		$seo .= '<meta name="description" content="蹦蹦哒轮胎帮助您快速查询到您想要的轮胎,为您提供完善的轮胎规格,花纹等信息" />';
		$seo .= '<link rel="canonical" href="http://www.bmbmda.com/p-'.$p.'" />';
        $seo .= '<link rel="alternate" media="only screen and (max-width: 640px)" href="http://m.bmbmda.com/p-'.$p.'" />';
		$this->assign("seo",$seo);


		$this->display("HomePage/home_list");

	}

}