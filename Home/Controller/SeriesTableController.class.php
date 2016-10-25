<?php
namespace Home\Controller;
use Think\Controller;
/**
*功能：只传入系列，公司，型号数据
*型号是表格形式，系列外部添加
*添加后传入系列id
*/
  class SeriesTableController extends Controller {
    private $brandid;
    private $catid;
    private $seriesid;
    private $seriesid_other;
    private $companyid;
    private $company_alias;
    private $modelid;
    private $goodsid;
    private $model;
    private $thumb;
    private $org_thumb;
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
            $this->catid = $category_info['catid'];
        }
        // 公司
        $company_alias = I('company','');
        if(empty($company_alias))
        {
            echo '公司不能为空';
            die;
        }else{
            $company_alias = trim($company_alias);
        }
        $company_info = M('Company')->where(array('company_alias'=>$company_alias))->find();
        if(empty($company_info))
        {
            echo '公司不存在';
            die;
        }else{
            $this->companyid = $company_info['companyid'];
            $this->company_alias = $company_info['company_alias'];
            $this->company_name = $company_info['company_name'];
        }
         //1 图片处理
        $thumb = '';
        $thumb_tmp = '';
        $series_img = '';
        if(!empty($source_imgurl))
        {
          $image_cmd5 = md5($source_imgurl);
          $m_image = M('series_img');
          $series_img = $m_image->where(array('image_cmd5'=>$image_cmd5))->find();
          if(!$series_img)
          {
              $thumb_tmp = img_download($source_imgurl,$upload_path,'series');
              if($thumb_tmp['code'] == 1)
              {
                  $imagePath = $thumb_tmp['imagePath'];
                  $new_thumb = $this->thumb($imagePath);

                  $app_path = APP_PATH;
                  $thumb = str_replace($app_path, '', $imagePath);
                  $m_image->add(array("image_cmd5"=>$image_cmd5,"image_url"=>$source_imgurl,"local_image_url"=>$new_thumb,'org_thumb'=>$thumb));
              }
          }else{
              $thumb = $series_img['local_image_url'];
          }
          $this->thumb = $new_thumb;
          $this->org_thumb = $thumb;
        }
        //型号
        $model_str = I('model','');
        if(empty($model_str))
        {
          echo '型号名称不能为空';
          die;
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
        //系列英文名
        $series_alias = I("series_alias",'');
        if(empty($series_alias)){
          echo "系列英文名不能为空";
          exit;
        }else{
          $series_alias = get_substr($series_alias,100);
          if(empty($series_alias))
          {
              echo '系列长度超过255';
              die();
          }
        }
        //系列内容
        $series_content = I("series_content",'');
        if(empty($series_content)){
          $series_content = '';
        }
        $this->series_content = $series_content;
      /*============添加数据===============*/
        //1 添加系列
        $this->addSeries(array("series_name"=>$series,"series_alias"=>$series_alias));
        //添加缺气保用轮胎
        if(preg_match('/缺气保用轮胎/', $model_str))
        {
            $series_data = array(
                "series_name"=>'缺气保用轮胎',
                "series_alias"=>'run-flat tire',
                );
            $series_rs = $this->addSeries_other($series_data);
            if(!$series_rs)
            {
              echo $this->error;
              die;
            }
        }
        //2 型号表格添加
        $model_arr_tr = array();
        // $model_arr1 = explode("</h>", $model_str);
        preg_match_all("/&lt;tr&gt;(.*?)&lt;\/tr&gt;/", $model_str, $model_arr_tr);
        foreach ($model_arr_tr[1] as $key_tr => $value_tr) {
            $model_arr_td = array();
            if(!empty($value_tr))
            {
                preg_match_all("/&lt;td&gt;(.*?)&lt;\/td&gt;/", $value_tr, $model_arr_td);
                $modelid = '';
                foreach ($model_arr_td[1] as $key_td => $value_td) {
                    $tmp = array();
                    if(!empty($value_td))
                    {
                       $tmp = explode("=&gt;", $value_td);
                       if(empty($tmp[0]) or empty($tmp[1]))
                       {
                          continue;
                       }
                       $result = '';
                       $result = $this->addTableData($tmp[0],$tmp[1]);
                       if(!$result)
                       {  echo $this->error;
                       }
                       if($this->error == "产品已经存在")
                       {
                          echo $this->error;
                       }
                    }
                    
                }
            }
       }
       //系列花纹资源
       $series_resource = I("series_resource",'');
       if(!empty($series_resource))
       {
          $this->dealSeriesResource($series_resource);
       }
       echo "success";
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
    $brandid = $this->brandid;
    $catid = $this->catid;
    $companyid = $this->companyid;
    $thumb = $this->thumb;
    $org_thumb = $this->org_thumb;

    $modelid = '';
    $findmodel = M('model')->where(array('model_name'=>$model,"brandid"=>$brandid,"catid"=>$catid))->find();
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
    $brandid = $this->brandid;
    $catid = $this->catid;
    $seriesid = $this->seriesid;
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
        $check_title = $title.$company_alias;
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
      $value = trim(preg_replace('/-/','',$value));
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