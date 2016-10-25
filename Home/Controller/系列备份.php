<?php
namespace Home\Controller;
use Think\Controller;
/**
*针对,只有系列和型号，图片只有系列图片,系列下面是规格（型号）列表
*/
class SeriesTableController extends Controller {
    private $brandid;
    private $catid;
    private $seriesid;
    private $companyid;
    public function index()
    {
        error_reporting(E_ALL);
        ini_set('max_execution_time', 900);

        $upload_path = APP_PATH.'/Images/';
        //品牌

        $brandname = trim(I('brandname',''));
        if(empty($brandname))
        {
          echo '品牌不能为空';
          die;
        }else{
          $brandname = get_substr($brandname,255);
          if(empty($brandname))
          {
              echo '品牌长度超过255';
              die;
          }
          $brand['brand_name'] = $brandname;
          //检查品牌是否存在
          $brand_info = M('Brand')->where(array('brand_name'=>$brandname))->find();
          if(empty($brand_info))
          {
              echo '匹配不到品牌:'.$brandname;
              die();
          }else{
              $this->brandid = $brand_info['brandid'];
              $brandid = $brand_info['brandid'];
          }
        }
        //图片
        $source_imgurl = I("thumb",'');
        if(!empty($source_imgurl)){
          if(!preg_match('/[http | https]/', $source_imgurl))
          {
            echo "图片格式不对，没有http[s]";
            die;
          }
        }else{
          $source_imgurl = '';
        }
        //系列
        $series = I("series",'');
        if(empty($series)){
          echo "系列不能为空";
          exit;
        }else{
          $series = get_substr($series,255);
          if(empty($series))
          {
              echo '系列长度超过255';
              die();
          }
        }
        //属性规格
        $spec = I("spec",'');
        $goods_param = array();
        $goods_value = array();
        if(!empty($spec)){
            $arr_spec = explode("||",$spec);
            foreach($arr_spec as $v){
                $v = explode("=>",$v);
                list($para,$value) = $v;
                $para = get_substr($para,255);
                $value = get_substr($value,255);
                if(empty($para) or empty($value))
                {
                    continue;
                }
                $goods_param[] = $para;
                $goods_value[] = $value;
            }
        }
        //系列内容
        $series_content = I("series_content",'');
        if(empty($series_content)){
          $series_content = '';
        }
        //精确匹配分类，获取型号对应分类
        $catname = I("catname",'');
        if(empty($catname)){
          echo "分类不能为空";
          exit;
        }else{
            $catname = get_substr($catname,255);
            if(!$catname)
            {
                echo '分类长度超过255';
                die();
            }
            $category_info = M('Category')->where(array('cat_name'=>$catname))->find();
            if(empty($category_info))
            {
                echo "匹配不到分类信息，请添加分类";
                die; 
            }
            // dump($category['catid']);
            $this->catid = $category_info['catid'];
            $catid = $category_info['catid'];
        }
        //公司名称 英文名
        $company_name = I("company",'');
        if(empty($company_name)){
          echo "公司名称不能为空";
          die;
        }else{
            $company_name = get_substr($company_name,255);
            if(empty($company_name))
            {
                echo '公司长度超过 255';
                die();
            }
            $company_info = M('Company')->where(array('company_alias'=>$company_name))->find();
            if(empty($company_info))
            {
                echo "匹配不到公司信息，请添加公司";
                exit; 
            }
            $this->companyid = $company_info['companyid'];
            $companyid = $company_info['companyid'];
        }
        //数据来源地址
        $source_url = I("source_url",'');
        if(empty($source_url)){
          echo "数据来源地址不能为空";
          exit;
        }else{
          $source_url = get_substr($source_url,255);
          if(empty($source_url))
          {
              echo '数据来源地址长度超过 255';
              die();
          }
        }
        //最低价格
        $minprice = I("minprice",'');
        if(empty($minprice)){
          $minprice = 0;
        }
        $minprice = preg_replace("/[^0-9\.]+/","",$minprice);
        $minprice = floatval($minprice);
        //最高价格
        $maxprice = I("maxprice",'');
        if(empty($maxprice)){
          $maxprice = $minprice;
        }
        $maxprice = preg_replace("/[^0-9\.]+/","",$maxprice);
        $maxprice = floatval($maxprice);
        $goods['min_price'] = $minprice;
        $goods['max_price'] = $minprice;
        
        //产品标题
        $title = I("title",'');
        

        /*=========数据添加或修改开始============================*/
        /*//所有数据
        $source_imgurl//图片
        $attrs//属性规格
        $series//系列
        $category//分类  
        $company//公司  
        $source_url//数据来源地址
        $maxprice//价格
        $minprice//价格
        $title//产品标题
        $brandData//品牌*/
        
        //1 图片处理
        $thumb = '';
        $thumb_tmp = '';
        if(!empty($source_imgurl))
        {
          $image_cmd5 = md5($source_imgurl);
          $m_image = M('series_img');
          $series_img = $m_image->where(array('image_cmd5'=>$image_cmd5))->find();
          if(!$series_img)
          {
              $thumb_tmp = $this->img_download($source_imgurl,$upload_path,'series');
              if($thumb_tmp['code'] == 1)
              {
                  $thumb = $thumb_tmp['imagePath'];
                  $m_image->add(array("image_cmd5"=>$image_cmd5,"image_url"=>$source_imgurl,"local_image_url"=>$thumb));
              }
          }else{
              $thumb = $series_img['local_image_url'];
          }
        }
        //2 系列数据的添加，系列资源？怎么来的
        $seriesid = '';
        $add_series = $this->addSeries($series,$thumb,$series_content);
        if($add_series['code'] == 0)
        {
            echo "系列插入数据出错，请重试";
            die;
        }else{
           $series_message = $add_series['message'];
           $seriesid = $add_series['seriesid'];
        }

        //型号
        $model_str = I('model','');
        if(empty($model_str))
        {
          echo '型号名称不能为空';
          die;
        }else{
            $model_arr1 = array();
            $model_arr1 = explode("<h>", $model_str);
            foreach ($model_arr1 as $key1 => $value1) {
                $model_arr2 = array();
                if(!empty($value1))
                {
                    $model_arr2 = explode("||", $value1);
                    $modelid = '';
                    foreach ($model_arr2 as $key2 => $value2) {
                        $tmp = array();
                        if(!empty($value2))
                        {
                           $tmp = explode("=>", $value2);
                           if($tmp[0] = '规格')
                           {
                              
                           }
                           $this->addGoodSpecSingle($key,$value,$goodsid);
                        }
                        
                    }
                }
           }
          /*foreach ($model_arr as $key => $value) {
              $count = 0;
              $modelid = '';
              $goods_spec = array();
              $model_replace = array();
              $model_tmp = '';
              foreach ($value as $k => $v) {
                 if($k == '规格')
                 {
                    $model_tmp = $v;
                    $modelid = $this->addModel($v,$seriesid);
                 }elseif($k == '可替换尺寸'){
                    $model_replace = explode('<br />', $v);
                 }else{
                    $goods_spec[] = array($k=>$v);
                 }
              }
              $goods_tmp = array();
              $this->addModelReplace($model_replace,$modelid);
              $goods_tmp = $this->addGoods($brand_info,$category_info,$model_tmp,$company,$seriesid,$goods,$title,$modelid,$thumb,$goods_content);
              if($goods_tmp['code'] == 2)
              {
                 $this->addGoodSpec($goods_spec,$goodsid);
              }elseif($goods_tmp['code'] == 1){
                  echo "产品已经存在";
              }
          }*/
        }
        /*========数据添加或修改结束============================*/
}
/*添加替换型号*/
public function addModelReplace($model_arr,$modelid)
{
  foreach ($model_arr as $key => $value) {
      $info = '';
      $data = array();
      $data = array('modelid'=>$modelid,'model'=>$value);
      $info = M('model_replace')->where($data)->find();
      if($info or empty($modelid))
      {
        continue;
      }else{
        M('model_replace')->add($data);
      }
  }
}
/*添加型号*/
public function addModel($model = '',$seriesid)
{
    $brandid = $this->brandid;
    $catid = $this->catid;
    $companyid = $this->companyid;
    $modelid = '';
    $findmodel = M('model')->where(array('model'=>$model,"brandid"=>$brandid,"catid"=>$catid))->find();
    if(!$findmodel){//新增型号
        //添加型号数据
        $linkurl = preg_replace("/[^0-9a-zA-Z]/i","-",$model);
        $linkurl = preg_replace("/(-)+/i","-",$linkurl);
        
        $model_data = array("seriesid"=>$seriesid,"model_name"=>$model,"brandid"=>$brandid,"catid"=>$catid,"linkurl"=>$linkurl);
        $modelid = M('model')->add($model_data);
        //型号参数开始====================
        if(!$modelid){
            // echo "型号添加失败:".$model;
            return false;
        }         
    }else{
        $modelid = $findmodel['modelid'];
    }
    return $modelid;
}
/*添加产品*/

public function addGoods($brand_info,$category_info,$model,$company,$seriesid,$goods,$title,$modelid,$thumb,$goods_content)
{
    $brandid = $this->brandid;
    $catid = $this->catid;
    $companyid = $this->companyid;
    //产品标题处理
    if(empty($title)){
      $title = $brand_info['brand_name']." ".$category_info['cat_name']." ".$model;
    }
    $en_title = $brand_info['brand_alias']." ".$category_info['cat_alias']." ".$model;//英文名
        // dump($title);
        //检查产品是否存在
        $check_title = $title.$company['company_alias'];
        $goods_cmd5 = md5($check_title);
        $goods_check_info = M('goods_check')->where(array('stringmd5'=>$goods_cmd5))->find();
        if(!$goods_check_info){
            /*===检查产品是否存在开始=========================*/
            $find_goods = M('goods')->where(array("modelid"=>$modelid,"companyid"=>$companyid,"seriesid"=>$seriesid))->find();
            if(empty($find_goods)){//新增产品
                $goods_linkurl = preg_replace("/[^a-zA-Z0-9]+/","-",$en_title);
                $goods_linkurl = preg_replace("/(-)+/i","-",$goods_linkurl);
                $goods['title'] = $title;
                $goods['en_title'] = $en_title;
                $goods['linkurl'] = $goods_linkurl;
                //图片处理开始
                if(!empty($source_imgurl))
                {
                    $goods_thumb = str_replace($upload_path,"",$this->img_download($source_imgurl,$upload_path,0));
                }
                $goods['catid'] = $catid;
                $goods['brandid'] = $brandid;
                $goods['modelid'] = $modelid;
                $goods['seriesid'] = $seriesid;
                $goods['companyid'] = $companyid;
                $goods['model'] = $model;
                $goods['currency'] = 'RMB';
                $goods['addtime'] = TIMESTAMP;//时间
                if(!empty($thumb))
                {
                    $goods['thumb'] = $thumb;
                }
                $goodsid = '';
                $goodsid = M('goods')->add($goods);
                if($goodsid){
                    //商品检查表
                    M('goods_check')->add(array("stringmd5"=>$goods_cmd5,"goodsid"=>$goodsid));
                    //商品内容表
                    if(empty($goods_content))
                    {
                      $goods_content = '';
                    }
                    M('goods_content')->add(array("goodsid"=>$goodsid,"content"=>$goods_content,"resource_url"=>$source_url));
                   return array('code'=>2,"message"=>"success","goodsid"=>$goodsid);
              }else{
                return array('code'=>0,"message"=>"产品添加失败");
              }
            }
        }
        return array('code'=>1,"message"=>"产品已经存在");
}
/*添加商品参数*/
public function addGoodSpec($goods_param,$goodsid)
{
    foreach($goods_param as $key=>$value){
      $key = trim($key);
      $value = trim(preg_replace('/-/','',$value));
      if(empty($key) or empty($value)){
        continue;
      }
      $this->addGoodSpecSingle($key,$value,$goodsid);
      

    }
}
/*添加商品参数*/
public function addGoodSpecSingle($param,$value,$goodsid)
{
    $param_model = M("goods_param");
    $value_model = M("goods_value");

    $param_info = '';
    $paraid = '';
    $param_info = $param_model->where(array('param'=>$param))->find();
    if($param_info){
        $paraid = $param_info['paraid'];
    }else{
        $paraid = $param_model->add(array('param'=>$param));
    }
    $value_info = '';
    if($paraid)
    {
        $value_info = $value_model->where(array("paraid"=>$paraid,"goodsid"=>$goodsid,"value"=>$value))->find();
        if(!$value_info)
        {
            $value_model->add(array("paraid"=>$paraid,"goodsid"=>$goodsid,"value"=>$value));

        }
    }

}
 
  /*添加系列*/
  public function addSeries($series_name = '',$thumb = '',$series_content = ''){
      $brandid = $this->brandid;
      $catid = $this->catid;
      $companyid = $this->companyid;
      $series = array();
      $seriesid = '';
      $series = M('Series')->where(array("brandid"=>$brandid,"catid"=>$catid,"series_name"=>$series_name))->find();
      if(!$series){//新增加系列
          $message = "新增加系列:";
          $createdata['series_name'] = $series_name;
          if(!empty($thumb))
          {
             $createdata['thumb'] = $thumb;
          }
          $createdata['brandid'] = $brandid;
          $createdata['catid'] = $catid;
          $createdata['companyids'] = $companyid;
          $tmp_str = '';
          $tmp_str = preg_replace('/[^0-9a-zA-Z]/'," ", $createdata['series_name']);
          $tmp_str = trim($tmp_str);
          $createdata['letter'] = strtoupper(substr($tmp_str,0,1));
          $createdata['linkurl'] = preg_replace('/[^0-9a-zA-Z]/i','-',$tmp_str);
          $createdata['linkurl'] = preg_replace('/(-)+/i','-',$createdata['linkurl']);
          $seriesid = M('Series')->add($createdata);
          if($seriesid){
              $message = "新增加系列:".$seriesid;
              //添加型号内容
              if(!empty($series_content))
              {
                  M('series_content')->add(array('seriesid'=>$seriesid,'content'=>$series_content));
              }
          }else{
              $message = "新增系列失败:".$series_name;
          }
      }else{//修改系列
          $seriesid = $series['seriesid'];
          if(empty($series['companyids'])){
            $companyids = array();
          }else{
            $companyids = explode(",",$series['companyids']);
          }
          if(in_array($companyid,$companyids)){
            $message = "系列已经存在:".$series_name;
          }else{
            $companyids[] = $companyid;
            $companyids_str = implode(",",$companyids);
            M('series')->where(array("seriesid"=>$seriesid))->save(array("companyids"=>$companyids_str));
            $message = "更新系列:companyids{$companyids}";
          }
      }
      //系列资源
      if(!empty($seriesid))
      {
          return array('code'=>1,'seriesid'=>$seriesid,'message'=>$message);
      }else{
          return array('code'=>0,'message'=>$message);
      }
      
  }

}