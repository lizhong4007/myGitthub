<?php
namespace tyreWWW\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index()
    {
        $catid = (int)I('catid','');
        //分类
        $M_Category = D('Category');
        $catids = array();
        $sub_category = $M_Category->getCategoryByParentid($catid);
        foreach ($sub_category as $key => $value) {
          $catids[] = $value['catid'];
        }
        $catids[] = $catid;
        $category = $M_Category->getCategoryList();
        $current_category = $category[$catid];
        $parent_category = $category[$current_category['parentid']];
        $this->assign("current_category",$current_category);
        $this->assign("parent_category",$parent_category);
        //系列
        $series = D("Series")->getSeriesData(array('catid'=>array('in',$catids)));
        $this->assign("series",$series);
        /*// print_r($series);exit();

        //品牌
        $brand = array();
        $brand_data = array();
        $M_brand = D('Brand');
        foreach ($series as $key => $value) {
          $tmp = '';
          $tmp = $M_brand ->getBrand($value['brandid']);
          $value['brand'] = $tmp;
          $brand[] = $tmp;
          $brand_data[] = $value;
        }
        $brand = array_unique($brand);
        $this->assign("brand",$brand);*/

        //品牌
        $brand = array();
            $brandids = array();
        foreach ($series as $key => $value) {
          $brandids[] = $value['brandid'];
        }
        $brandids = array_unique($brandids);
        $M_brand = D('Brand');
        if(!empty($brandids))
        {
           $brand = $M_brand->getBrandData(array('brandid'=>array('in',$brandids)));
        }
        $this->assign("brand",$brand);
        // 商品
        $where = array();
        //筛选条件
        $this->assign("catid",$catid);
        $seriesid = (int)I('seriesid','');
        if(!empty($seriesid))
        {
          $where['seriesid'] = $seriesid;
        }
        $p = (int)I('p',1);
        $size = 20;
        $where['catid'] = array('in',$catids);
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
        // print_r($brand);exit;

        $this->display("Goods/List");

    }
}