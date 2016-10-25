<?php
namespace Home\Controller;
use Think\Controller;
/**
*功能：只传入系列，公司，型号数据
*型号是表格形式，系列外部添加
*添加后传入系列id
*/
class CoopertireController extends Controller {
    private $brandid = 9;
    private $brand_name = '耐克森';
    private $catid = 13;
    private $seriesid = 103;
    private $seriesid_other;
    private $series_name = 'N9000';
    private $companyid = '7';
    private $company_name = '耐克森';
    private $thumb = '/Images/thumb/2016/10/21/1477054257_4484.png';
    private $org_thumb = '/Images/series/2016/10/21/1477054257_4484.png';

    private $modelid;
    private $goodsid;
    private $model;
    private $error;
    private $source_url;
    private $upload_path;
    public function index()
    {
        error_reporting(E_ALL);
        ini_set('max_execution_time', 900);

        $upload_path = APP_PATH.'/Images/';
        $this->upload_path = $upload_path;

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
          //检查网址是否被采集过
          $source_url_cmd5 = md5($source_url);
          $source_url_info = M("check_site")->where(array("cmd5"=>$source_url_cmd5))->find();
          if($source_url_info)
          {
             echo "网址已经被采集过";
             die;
          }else{
             M("check_site")->add(array("cmd5"=>$source_url_cmd5,"source_url"=>$source_url));
          }
          $this->source_url = $source_url;
        }
       
        //型号
        $model_str = I('model','');
        if(empty($model_str))
        {
          echo '型号名称不能为空';
          die;
        }
        //车型数据
        $cars = I("brandname",'');
       
      /*============添加数据===============*/
      //1 型号表格添加
      $seriesid = $this->seriesid;
        $model_arr_tr = array();
        preg_match_all("/&lt;tr&gt;(.*?)&lt;\/tr&gt;/", $model_str, $model_arr_tr);
        foreach ($model_arr_tr[1] as $key_tr => $value_tr) {
            $model_arr_td = array();
            if(!empty($value_tr))
            {
                preg_match_all("/&lt;td&gt;(.*?)&lt;\/td&gt;/", $value_tr, $model_arr_td);
                $this->addModel($model_arr_td[1][0],$seriesid);
                $XL = 0;
                  if(!empty($model_arr_td[1][2]))
                  {
                    if(preg_match('/XL/', $model_arr_td[1][2]))
                    {
                       $XL = 1;
                       $model_arr_td[1][2] = preg_replace('/XL/', '', $model_arr_td[1][2]);
                    }
                    if(preg_match('/LT/', $model_arr_td[1][2]))
                    {
                       $XL = 3;
                       $model_arr_td[1][2] = preg_replace('/LT/', '', $model_arr_td[1][2]);
                    }
                  }
                  //产品
                  $goods = array();
                  $goods['is_enhance'] = $XL;
                  $this->addGoods($goods);
                $weight = $model_arr_td[1][1];//负荷
                  $weight = preg_replace('/[^a-zA-Z]/', '', $weight);
                  $weight = strtoupper($weight);
                  $this->addGoodSpec(array('速度级别符号'=>$weight));
                /*foreach ($model_arr_td[1] as $key_1 => $value_1) {
                  $tmp = array();
                  $value_1 = trim($value_1);
                  $tmp = explode(' ', $value_1);
                  //型号
                  $this->addModel($tmp[0],$seriesid);
                  //是否xl
                  $XL = 0;
                  if(!empty($tmp[2]))
                  {
                    if(preg_match('/XL/', $tmp[2]))
                    {
                       $XL = 1;
                       $tmp[2] = preg_replace('/XL/', '', $tmp[2]);
                    }
                    if(preg_match('/LT/', $tmp[2]))
                    {
                       $XL = 3;
                       $tmp[2] = preg_replace('/LT/', '', $tmp[2]);
                    }
                    if(!preg_match('/XL/', $tmp[2]) and !preg_match('/LT/', $tmp[2]))
                    {
                      $tmp[2] = preg_replace('/FR/', '', $tmp[2]);
                      $tmp[2] = preg_replace('/SSR/', '', $tmp[2]);
                      if(!empty($tmp[2]))
                      {
                        $carsids = $this->addCars($tmp[2]);
                        $model_cars = array();
                        $model_cars['model_name'] = $tmp[0];
                        $model_cars['carsids'] = $carsids;
                        $this->addModelCars($model_cars);
                      }

                    }
                  }
                  //产品
                  $goods = array();
                  $goods['is_enhance'] = $XL;
                  $this->addGoods($goods);

                  //参数
                  $fuhe = $tmp[1];//负荷
                  $fuhe = preg_replace('/[^0-9\/]/', '', $fuhe);
                  $this->addGoodSpec(array('负重指数'=>$fuhe));
                  $weight = $tmp[1];//负荷
                  $weight = preg_replace('/[^a-zA-Z]/', '', $weight);
                  $weight = strtoupper($weight);
                  $this->addGoodSpec(array('速度级别符号'=>$weight));

                  //添加车型和型号匹配数据表
                  if(!empty($tmp[3]))
                  {
                    $tmp[3] = preg_replace('/FR/', '', $tmp[3]);
                    $tmp[3] = preg_replace('/SSR/', '', $tmp[3]);
                    if(!empty($tmp[3]))
                    {
                      $carsids = $this->addCars($tmp[3]);
                      $model_cars = array();
                      $model_cars['model_name'] = $tmp[0];
                      $model_cars['carsids'] = $carsids;
                      $this->addModelCars($model_cars);
                    }

                  }
                  

                }*/
                
              

            }
       }

       
      
}

/*添加车型和型号匹配数据表
*/
private function addModelCars($model_cars = array())
{
    /*$model_cars['brandid'] = $this->brandid;
    $model_cars['brand_name'] = $this->brand_name;*/
    $model_cars['seriesid'] = $this->seriesid;
    $model_cars['series_name'] = $this->series_name;
    $model_cars['companyid'] = $this->companyid;
    $model_cars['company_name'] = $this->company_name;
    $series_info = array();
    $series_info = D('Series')->getSeries($model_cars['seriesid']);
    $catid = $series_info['catid'];
    $model_cars['brandid'] = $series_info['brandid'];
    //品牌
    $brand_info = array();
    $brand_info = D('Brand')->getBrand($model_cars['brandid']);
    if(!$brand_info)
    {
       $this->error = "品牌不存在";
       return false;
    }
    $model_cars['brand_name'] = $brand_info['brand_name'];

    $modelid = 0;
    $model_name = get_substr($model_cars['model_name'],50);
    $model_info = '';
    $model_info = M('Model')->where(array('model_name'=>$model_name,'brandid'=>$model_cars['brandid'],'seriesid'=>$model_cars['seriesid'],'catid'=>$catid))->find();
    if($model_info)
    {
       $model_cars['modelid'] = intval($model_info['modelid']);
    }
    $info = '';
    $info = M('model_cars')->where($model_cars)->find();
    if($info)
    {
      $str = array();
      $str_tmp = '';
      if(!empty($info['carsids']))
      {
         $str = explode(',', $info['carsids']);
         if(in_array($model_cars['carsids'], $str))
         {
            return false;
         }
         $str_tmp = $info['carsids'].','.$model_cars['carsids'];
      }else{
         $str_tmp = $model_cars['carsids'];
      }
      M('model_cars')->where(array('id'=>$info['id']))->save(array('carsids'=>$str_tmp));
      return false;
    }else{
      M('model_cars')->add($model_cars);
    }

}
/*判断表并插入数据
添加车型
*/
private function addCars($car_name = '',$is_import = 0)
{
   $car_name = get_substr($car_name,100);
   $is_import = intval($is_import);
   $M_cars = M('cars');
   $info = '';
   $info = $M_cars->where(array('car_name'=>$car_name,'is_import'=>$is_import))->find();
   if($info)
   {
      return $info['carid'];
   }else{
      return $M_cars->add(array('car_name'=>$car_name,'is_import'=>$is_import));
   }

}
/*判断表并插入数据
*$key=>表属性
*$value=>表的值
*/
private function addTableData($key,$value)
{
   $this->error = '';
   $seriesid = $this->seriesid;
   $seriesid_other = $this->seriesid_other;
   $key = trim($key);
   $value = trim($value);
   $modelid = '';
   //型号添加
   if($key == '规格')
   {
      $model_tmp = '';
      $seriesid_tmp = '';
      $is_uhp = 0;
      
      if(preg_match('/缺气保用轮胎/', $value))
      {
          $seriesid_tmp = $seriesid_other;
      }else{
          $seriesid_tmp = $seriesid;
      }
      $model_tmp = str_replace('缺气保用轮胎', '', $value);
      $model_tmp = strtolower($model_tmp);
      if(preg_match('/uhp/', $model_tmp))
      {
         $is_uhp = 1;
      }
      $model_tmp = preg_replace('/uhp/', '', $model_tmp);
      
      $model_tmp = trim($model_tmp);
      if(empty($model_tmp))
      {
         return false;
      }
      $modelid = $this->addModel($model_tmp,$seriesid_tmp,$is_uhp);
      if(!$modelid)
      {
        return false;
      }
      $goods_rs = $this->addGoods();
      if(!$goods_rs)
      {
        return false;
      }
   }elseif($key == '可替换尺寸')
   {
      $model_replace = '';
      $model_replace = preg_replace("/<br>/", '', $value);
      $model_replace_tmp = array();
      $model_replace_tmp = explode("&lt;br /&gt;", $model_replace);
      $this->addModelReplace($model_replace_tmp);
   }else{//产品参数,先增加产品，在增加参数
      $this->addGoodSpec(array($key=>$value));
   }
   
   return true;
}
/*添加替换型号*/
private function addModelReplace($model_arr)
{
  $this->error = '';
  $modelid = $this->modelid;
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
/*添加型号,型号名称*/
private function addModel($model,$seriesid,$is_uhp = 0)
{
    $this->error = '';
    if(empty($model))
    {
       $this->error = "型号名称不能为空";
       return false;
    }
    $series_info = array();
    $series_info = D('Series')->getSeries($seriesid);
    $catid = $series_info['catid'];
    $brandid = $series_info['brandid'];

    $model = trim($model); 
    /*$brandid = $this->brandid;
    $catid = $this->catid;*/
    $companyid = $this->companyid;
    $thumb = $this->thumb;
    $org_thumb = $this->org_thumb;

    $modelid = '';
    $findmodel = M('model')->where(array('model_name'=>$model,"brandid"=>$brandid,"catid"=>$catid,'seriesid'=>$seriesid))->find();
    if(!$findmodel){//新增型号
        //添加型号数据
        $linkurl = preg_replace("/[^0-9a-zA-Z]/i","-",$model);
        $linkurl = preg_replace("/(-)+/i","-",$linkurl);
        $model_data = array();
        if(!empty($is_uhp))
        {
          $model_data['is_uhp'] = 1;
        }
        $model_data['seriesid'] = $seriesid;
        $model_data['model_name'] = strtoupper($model);
        $model_data['brandid'] = $brandid;
        $model_data['catid'] = $catid;
        $model_data['linkurl'] = strtolower($linkurl);
        $model_data['thumb'] = $thumb;
        $model_data['org_thumb'] = $org_thumb;
        $model_data['addtime'] = TIMESTAMP;
        $modelid = M('model')->add($model_data);
        //型号参数开始====================
        if(!$modelid){
            $this->error = "添加型号失败";
            return false;
        }         
    }else{
        $modelid = $findmodel['modelid'];
    }
    $this->modelid = $modelid;
    $this->model = $model;
    return true;
}
/*添加产品*/
private function addGoods($goods = array())
{
    $this->error = '';
    /*$brandid = $this->brandid;
    $catid = $this->catid;*/
    $seriesid = $this->seriesid;
    $series_info = array();
    $series_info = D('Series')->getSeries($seriesid);
    $catid = $series_info['catid'];
    $brandid = $series_info['brandid'];
    
    $companyid = $this->companyid;
    $company_alias = $this->company_alias;
    $modelid = $this->modelid;
    $model = $this->model;
    $thumb = $this->thumb;
    $org_thumb = $this->org_thumb;
    $source_url = $this->source_url;
    //品牌
    $brand_info = array();
    $brand_info = D('Brand')->getBrand($brandid);
    if(!$brand_info)
    {
       $this->error = "品牌不存在";
       return false;
    }
    //分类
    $category_info = array();
    $category_info = D('Category')->getCategory($catid);
    if(!$category_info)
    {
       $this->error = "分类不存在";
       return false;
    }
    //产品标题处理
    $title = '';
    if(empty($goods['title'])){
      $title = $brand_info['brand_name']." ".$category_info['cat_name']." ".$model;
    }else{
      $title = $goods['title'];
    }
    $catname_str = preg_replace('/[^a-zA-Z0-9]/', '-', $category_info['cat_alias']);
    $brandname_str = preg_replace('/[^a-zA-Z0-9]/', '-', $brand_info['brand_alias']);
    $en_title = $brandname_str." ".$catname_str." ".$model;//英文名
        // dump($title);
        //检查产品是否存在
        $check_title = $title.$company_alias.$seriesid;
        $goods_cmd5 = md5($check_title);
        $goods_check_info = M('goods_check')->where(array('stringmd5'=>$goods_cmd5))->find();
        if(!$goods_check_info)
        {
            /*===检查产品是否存在开始=========================*/
            $find_goods = M('goods')->where(array("modelid"=>$modelid,"companyid"=>$companyid,"seriesid"=>$seriesid))->find();
            if(empty($find_goods)){//新增产品

                $goods_linkurl = preg_replace("/[^a-zA-Z0-9]+/","-",$en_title.$company_alias);
                $goods_linkurl = preg_replace("/(-)+/i","-",$goods_linkurl);
                $goods['title'] = $title;
                $goods['en_title'] = strtolower($en_title);
                $goods['linkurl'] = strtolower($goods_linkurl);
                $goods['thumb'] = $thumb;
                $goods['org_thumb'] = $org_thumb;
                $goods['brand'] = $brand_info['brand_name'];
               
                $goods['catid'] = $catid;
                $goods['brandid'] = $brandid;
                $goods['modelid'] = $modelid;
                $goods['model'] = $model;
                $goods['seriesid'] = $seriesid;
                $goods['companyid'] = $companyid;
                $goods['currency'] = 'RMB';
                $goods['addtime'] = TIMESTAMP;//时间
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
                   $this->goodsid = $goodsid;
                   return true;
              }else{
                $this->error = "产品添加失败";
                return false;
              }
            }else{
              $this->goodsid = $find_goods['goodsid'];
            }
        }else{
            $this->goodsid = $goods_check_info['goodsid'];
        }
        $this->error = "产品已经存在";
        return true;
}
/*添加多条商品参数*/
public function addGoodSpec($goods_param = array())
{
    $this->error = '';
    $goodsid = $this->goodsid;
    foreach($goods_param as $key=>$value){
      $key = trim($key);
      $value = trim($value);
      if(empty($key) or empty($value)){
        continue;
      }
      $this->addGoodSpecSingle($key,$value,$goodsid);
    }
}
/*添加单条商品参数*/
public function addGoodSpecSingle($param,$value,$goodsid)
{
    $this->error = '';
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
/*添加缺气保用轮胎系列*/
public function addSeries_other($createdata = array()){
    $this->error = '';
      $brandid = $this->brandid;
      $catid = $this->catid;
      $companyid = $this->companyid;
      $thumb = $this->thumb;
      $org_thumb = $this->org_thumb;
      $series = array();
      $seriesid = $this->seriesid;
      $series_content = M('series_content')->where(array('seriesid'=>$seriesid))->find();
      $seriesid_other = '';
      $series = M('Series')->where(array("brandid"=>$brandid,"catid"=>$catid,"series_alias"=>$createdata['series_alias']))->find();
      if(!$series){//新增加系列
          if(!empty($thumb))
          {
             $createdata['thumb'] = $thumb;
          }
          $createdata['org_thumb'] = $org_thumb;
          $createdata['brandid'] = $brandid;
          $createdata['catid'] = $catid;
          $createdata['companyids'] = $companyid;
          $createdata['addtime'] = TIMESTAMP;
          $linkurl_tmp = '';
          if(!empty($createdata['series_alias']))
          {
            $linkurl_tmp = strtolower($createdata['series_alias']);
          }else{
            $linkurl_tmp = $createdata['series_name'];
          }
          if(!empty($linkurl_tmp))
          {
            $tmp_str = '';
            $tmp_str = preg_replace('/[^0-9a-zA-Z]/'," ", $linkurl_tmp);
            $tmp_str = trim($tmp_str);
            $createdata['letter'] = strtoupper(substr($tmp_str,0,1));
            $createdata['linkurl'] = preg_replace('/[^0-9a-zA-Z]/i','-',$tmp_str);
            $createdata['linkurl'] = preg_replace('/(-)+/i','-',$createdata['linkurl']);
            $createdata['linkurl'] = strtolower($createdata['linkurl']);
          }
          $seriesid_other = M('Series')->add($createdata);
          if($seriesid_other){
              //添加型号内容
              if(!empty($series_content['content']))
              {
                  M('series_content')->add(array('seriesid'=>$seriesid_other,'content'=>$series_content['content']));
              }
              $this->error = "新增系列:缺气保用轮胎";
              $this->seriesid_other = $seriesid_other;
              return ture;
          }else{
              $this->error = "新增系列失败";
              return false;
          }
      }else{//修改系列
          $seriesid_other = $series['seriesid'];
          $this->seriesid_other = $series['seriesid'];
          if(empty($series['companyids'])){
            $companyids = array();
          }else{
            $companyids = explode(",",$series['companyids']);
          }
          if(!in_array($companyid,$companyids)){
            $companyids[] = $companyid;
            $companyids_str = implode(",",$companyids);
            M('series')->where(array("seriesid"=>$seriesid_other))->save(array("companyids"=>$companyids_str));
            $this->error = "更新系列:companyids{$companyids_str}";
          }
          return true;
      }
  }

/*添加一般系列*/
public function addSeries($createdata = array()){
  $this->error = '';
      $brandid = $this->brandid;
      $catid = $this->catid;
      $companyid = $this->companyid;
      $thumb = $this->thumb;
      $org_thumb = $this->org_thumb;
      $series_content = $this->series_content;
      $series = array();
      $seriesid = '';
      $series_info = M('Series')->where(array("brandid"=>$brandid,"catid"=>$catid,"series_name"=>$createdata['series_name']))->find();
      if(!$series_info){//新增加系列
          if(!empty($thumb))
          {
             $createdata['thumb'] = $thumb;
          }
          $createdata['org_thumb'] = $org_thumb;
          $createdata['brandid'] = $brandid;
          $createdata['catid'] = $catid;
          $createdata['companyids'] = $companyid;
          $createdata['addtime'] = TIMESTAMP;
          $linkurl_tmp = '';
          if(!empty($createdata['series_alias']))
          {
            $linkurl_tmp = strtolower($createdata['series_alias']);
          }else{
            $linkurl_tmp = $createdata['series_name'];
          }
          if(!empty($linkurl_tmp))
          {
            $tmp_str = '';
            $tmp_str = preg_replace('/[^0-9a-zA-Z]/'," ", $linkurl_tmp);
            $tmp_str = trim($tmp_str);
            $createdata['letter'] = strtoupper(substr($tmp_str,0,1));
            $createdata['linkurl'] = preg_replace('/[^0-9a-zA-Z]/i','-',$tmp_str);
            $createdata['linkurl'] = preg_replace('/(-)+/i','-',$createdata['linkurl']);
            $createdata['linkurl'] = strtolower($createdata['linkurl']);
          }
          $seriesid = M('Series')->add($createdata);
          if($seriesid){
              //添加型号内容
              if(!empty($series_content))
              {
                  M('series_content')->add(array('seriesid'=>$seriesid,'content'=>$series_content));
              }
              $this->error = "新增系列:缺气保用轮胎";
              $this->seriesid = $seriesid;
              return ture;
          }else{
              $this->error = "新增系列失败";
              return false;
          }
      }else{//修改系列
          $seriesid = $series_info['seriesid'];
          $this->seriesid = $series_info['seriesid'];
          if(empty($series_info['companyids'])){
            $companyids = array();
          }else{
            $companyids = explode(",",$series_info['companyids']);
          }
          if(!in_array($companyid,$companyids)){
            $companyids[] = $companyid;
            $companyids_str = implode(",",$companyids);
            M('series')->where(array("seriesid"=>$seriesid))->save(array("companyids"=>$companyids_str));
          }
          return true;
      }
  }
  /*处理添加系列花纹资源*/
  private function dealSeriesResource($series_resource = '')
  {
      $seriesid = $this->seriesid;
      $upload_path = $this->upload_path;
 
      $resource_arr = explode("||", $series_resource);
      dump($resource_arr);
      foreach ($resource_arr as $key => $value) {
        $data_tmp = '';
        $data_tmp = explode("=&gt;", $value);
        if(empty($data_tmp[1]))//图片
        {
          continue;
        }
        // dump($data_tmp);
        $local_image = '';
        $local_image = img_download($data_tmp[1],$upload_path,'resource');
        $local_image_path = '';
        if($local_image['code'] == 1)
        {
            $app_path = APP_PATH;
            $local_image_path = str_replace($app_path, '', $local_image['imagePath']);
        }else{
          continue;
        } 
        //插入数据
        $insert = array();
        if(!empty($data_tmp[0]))
        {
           $insert['title'] = trim($data_tmp[0]);
        }else{
           $insert['title'] = '';
        }
        $insert['resource_url'] = $data_tmp[1];
        $insert['local_thumb'] = $local_image_path;
        $insert['org_thumb'] = $org_thumb;
        if(!empty($data_tmp[2]))
        {
           $insert['content'] = trim($data_tmp[2]);
        }else{
           $insert['content'] = '';
        }
        $insert['seriesid'] = $seriesid;
        $this->addSeriesResource($insert);
      }
  }
  /*处理添加系列花纹资源*/
  private function addSeriesResource($series_resource = array())
  {
      $info  = '';
      $info  = M('series_resource')->where(array("seriesid"=>$series_resource['seriesid'],"resource_url"=>$series_resource['resource_url']))->find();
      if($info)
      {
         return false;
      }else{
         M('series_resource')->add($series_resource);
      }
  }

  /*生成缩略图
  *$file完整路径
  */
  private function thumb($file = '')
  {
      $image = new \Think\Image(); 
      $image->open($file);
      $file_arr = explode('/',$file);
      $y_file = APP_PATH.'/Images/thumb/'.$file_arr[3];
      $this->make_dir($y_file);
      $m_file = $y_file.'/'.$file_arr[4];
      $this->make_dir($m_file);
      $d_file = $m_file.'/'.$file_arr[5];
      $file_name = $d_file.'/'.$file_arr[6];
      // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
      $image->thumb(300, 300)->save($file_name);

      $app_path = APP_PATH;
      $file = str_replace($app_path, '', $file);
      return $file;
  }
  /*生成文件*/
  private function make_dir($file = '')
  {
      if(!file_exists($file))
      {
        mkdir($file);
      }

  }
}