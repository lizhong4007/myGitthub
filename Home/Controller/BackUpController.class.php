<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
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
        }
        
        
        //型号
        $model = I('model','');
        if(empty($model))
        {
          echo '型号名称不能为空';
          die;
        }else{
          $model = get_substr($model,50);
          if(empty($model))
          {
              echo '型号长度超过50';
              die;
          }
          $model = trim($model);
        }

        //图片
        $source_imgurl = I("thumb",'');
        if(!empty($source_imgurl)){
          if(stripos($source_imgurl,"//")===false){
            echo "图片格式不对，没有http[s]";
            exit;
          }
        }else{
          $source_imgurl = '';
        }
 
        //属性规格
        $spec = I("spec");
        $attrs = array();
        if(!empty($spec)){
          $arr_spec = explode("||",$spec);
          foreach($arr_spec as $v){
            $v = explode("=>",$v);
            list($para,$value) = $v;
            $para = get_substr(strip_tags($para),50);
            if(empty($para))
            {
                continue;
            }
            $value = get_substr(strip_tags($value),100);
            if(empty($value))
            {
                continue;
            }
            $attrs[$para] = $value;
          }
        }else{
          //echo "型号规格不能为空";
          //exit;
        }

         $model_content = I("model_content",'');
           if(empty($model_content)){
          $model_content = '';
        }
        $content = $model_content;
        /*//型号内容
        $model_content = I("model_content",'');
        if(empty($model_content)){
          $model_content = '';
        }else{
          $content_image = array();
          if(preg_match_all("/<img[\s\S]*?src=[\'|\"](.*?)[\'|\"][\s\S]*?>/i",$model_content,$arrcontent)){
            $content_image = $arrcontent[1];
          }
        }
        $introduce = substr(strip_tags($model_content),0,255);*/

        //品牌资源
        $brand_resource = I("brand_resource",'');
        if(!empty($brand_resource))
        {
          $brand_resource_info = $this->makeResource($brand_resource);
          if($brand_resource_info['tag'] == 0)
          {
              echo $brand_resource_info['message'];
              die();
          }else{
              $brand_resource = $brand_resource_info['message'];
          }

        }       
        
        //系列资源
        $series_resource = I("series_resource",'');
        if(!empty($series_resource))
        {
          $series_resource_info = $this->makeResource($series_resource);
          if($series_resource_info['tag'] == 0)
          {
              echo $series_resource_info['message'];
              die();
          }else{
              $series_resource = $series_resource_info['message'];
          }

        }

        //型号资源
        $model_resource = I("resource",'');
        if(!empty($model_resource))
        {
          $model_resource_info = $this->makeResource($model_resource);
          if($model_resource_info['tag'] == 0)
          {
              echo $model_resource_info['message'];
              die();
          }else{
              $model_resource = $model_resource_info['message'];
          }

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

        //精确匹配分类，获取型号对应分类
        $catname = I("catname",'');
        if(empty($catname)){
          echo "分类不能为空";
          exit;
        }else{
            $catname = get_substr($catname,255);
            if(empty($catname))
            {
                echo '分类长度超过255';
                die();
            }
            $category = M('category')->where(array('cat_name'=>$catname))->find();
            if(empty($category))
            {
                echo "匹配不到分类信息，请添加分类";
                exit; 
            }
            // dump($category['catid']);
            $this->catid = $category['catid'];
            $catid = $category['catid'];
        }

        //公司
        $company_name = I("company",'');
        if(empty($company_name)){
          echo "公司不能为空";
          exit;
        }else{
            $company_name = get_substr($company_name,150);
            if(empty($company_name))
            {
                echo '公司长度超过 150';
                die();
            }
            $company = M('company')->where(array('company_name'=>$company_name))->find();
            if(empty($company))
            {
                echo "匹配不到公司信息，请添加公司";
                exit; 
                
            }
            $this->companyid = $company['companyid'];
            $companyid = $company['companyid'];
        }
     
        /*//系列内容
        $series_content = $this->input->post("series_content");
        if(empty($series_content)){
          $series_content = '';
        }*/
           
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

        //价格
        $minprice = I("minprice",'');
        if(empty($minprice)){
          $minprice = 0;
        }
        $minprice = preg_replace("/[^0-9\.]+/","",$minprice);
        $minprice = floatval($minprice);
        
        $maxprice = I("maxprice",'');
        if(empty($maxprice)){
          $maxprice = $minprice;
        }
        $maxprice = preg_replace("/[^0-9\.]+/","",$maxprice);
        $maxprice = floatval($maxprice);

        $timestamp = time();//时间

        //产品标题
        $title = I("title",'');
        

        /*==================数据添加或修改开始============================*/
        
        //1 品牌添加
        $brand_info = $this->addBrand($brandname);
        $brandData = array();
        $brandData = $brand_info['message'];
        if($brand_info['tag'] == 0)
        {
            foreach ($brand_info['note'] as $key => $value) {
               echo $value.'<br />';
            }
        }
        $this->brandid = $brandData['brandid'];
        $brandid = $brandData['brandid'];
        
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

        //2 图片的下载处理，是否已经采集过
        /*$default_thumb = 'Public/default/image/default.gif';
        if(empty($source_imgurl)){
          $thumb= $default_thumb;
        }else{
          $thumb_cmd5 = md5($source_imgurl);
          $find_resource = M('resource_check')->where(array("stringmd5"=>$thumb_cmd5))->find();
          $resid = '';
          if(!$find_resource){
              $thumb = str_replace($upload_path,"",$this->img_download($source_imgurl,$upload_path,0));
              if($thumb['tag'] != 0){
                dump("新增加图片资源地址:");
                $resid = M('resource')->add(array("res_type"=>'picture',"res_name"=>'picture',"resource"=>$thumb['imagePath'],"remark"=>"model"));
                M('resource')->add(array("resource_url"=>$source_imgurl,"stringmd5"=>$thumb_cmd5,"resid"=>$resid));
              }else{
                echo $thumb['message'].'<br />';
              }
              
          }else{
            dump("图片资源已经存在:");
            $resid = $find_resource['resid'];
            $get_resource = M('resource')->where(array("resid"=>$resid))->find();
            if($get_resource){
              $thumb = $get_resource['resource'];
            }else{
              $thumb = $default_thumb;
            }
            
          }
          
        }*/


        //3 系列数据的添加

        $series = $this->addSeries($series,$thumb,$series_content,$upload_path);
        $series_message = $series['message'];
        $seriesid = $series['seriesid'];
        dump($series_message);
        if(!$seriesid){
          echo "系列插入数据出错，请重试";
          exit;
        }

        //4 型号数据的添加
        $goods_thumb = '';//产品和型号图片
          
        $findmodel = M('model')->where(array('model'=>$model,"brandid"=>$brandData['brandid']))->find();
        if(!$findmodel){//新增型号
          if(!empty($model_resource)){
            $res_ids = $this->addResource($model_resource,$upload_path);
          }else{
            $res_ids = array();
          }
          $resids = implode(",",$res_ids);
          
          //添加型号数据
          $linkurl = preg_replace("/[^0-9a-z]/i","-",$model);
          $linkurl = preg_replace("/(-)+/i","-",$linkurl);
          
          if(!empty($source_imgurl))
          {
              $goods_thumb = str_replace($upload_path,"",$this->img_download($source_imgurl,$upload_path,0));
          }
          $model_data = array("seriesid"=>$seriesid,"model_name"=>$model,"brandid"=>$brandData['brandid'],"resids"=>$resids,"linkurl"=>$linkurl,'thumb'=>$goods_thumb);
          $modelid = M('model')->add($model_data);
          
          //型号参数开始====================
          if($modelid){
            /*if(!empty($attrs)) {
              foreach ($attrs as $para => $value) {
                $findmodel_spec = M('model_spec')->where(array('modelid'=>$modelid,"para"=>$para))->find();
                if(!$findmodel_spec and !empty($para) and !empty($value)){
                  $insert['modelid'] = $modelid;
                  $insert['para'] = trim($para);
                  $insert['value'] = trim($value);
                  $specid = M('model_spec')->add($insert);
                }
              }
            }*/
            echo "型号添加成功:".$modelid;
          }         
        }else{
           $modelid = $findmodel['modelid'];
           echo "型号存在:".$model;
        }
        /*else{//修改型号
          
          $modelid = $findmodel['modelid'];
          $resids  = $findmodel['resids'];
          
          //型号下是否有对应产品
          $findgoods = M('goods')->where(array("modelid"=>$modelid,"companyid"=>$companyid,"seriesid"=>$seriesid))->find();
          if($findgoods){
            dump("型号已经存在:".$model);
          }else{
            if(!empty($model_resource)){
              $res_ids = $this->addResource($model_resource,$upload_path);
              if(!empty($resids)){
                $resids = explode(",",$resids);
                $resids = array_merge($resids,$res_ids['resids']);
              }else{
                $resids = $res_ids['resids'];
              }
              $resids = array_unique($resids);
              $resids_arr = array();
              foreach ($resids as $key => $value) {
                if(!empty($value))
                {
                  $resids_arr[] = $value;
                }
              }
              $resids = implode(",",$resids_arr);
              M('model')->where(array('modelid'=>$modelid))->save(array("resids"=>$resids));
            }
            dump("更新型号资源");
          } 
        }*/


        //5 产品添加开始===============================
        //产品标题处理
        if(empty($title)){
          $title = $brandData['brand_name']." ".$category['cat_name']." ".$series['series_name']." ".$model;
        }
        // dump($title);
        //检查产品是否存在
        $check_title = $title.$company['company_alias'];
        $goods_cmd5 = md5($check_title);
        
        $goods_info = M('goods_check')->where(array('stringmd5'=>$goods_cmd5))->find();
        if($goods_info){
          echo "产品已经存在";
          die();
        }
        /*==================检查产品是否存在=========================*/
        // dump($goods_info);
        
        $find_goods = M('goods')->where(array("modelid"=>$modelid,"companyid"=>$companyid,"seriesid"=>$seriesid))->find();
        if(empty($find_goods)){//新增产品
          $linkurl = $company['company_alias'].$brandData['brand_alias'].$category['cat_alias'].$model;
          $linkurl = preg_replace("/[^a-zA-Z0-9]+/","-",$linkurl);
          
          //图片处理开始
          if(!empty($source_imgurl) and empty($goods_thumb))
          {
              $goods_thumb = str_replace($upload_path,"",$this->img_download($source_imgurl,$upload_path,0));
          }
          $newrecord=array(
            "catid"   =>  $catid,
            "brandid" =>  $brandid,
            "modelid" =>  $modelid,
            "seriesid"=>  $seriesid,
            "title"   =>  get_substr($title,255),
            "minprice"  =>  $minprice,
            "maxprice"  =>  $maxprice,
            // "currency"  =>  $currency,
            "thumb"   =>  $goods_thumb,
            "companyid"  =>  $companyid,
            "linkurl" =>  $linkurl,
          );
          $goodid = M('goods')->add($newrecord);
          if($goodid){
            //商品检查表
            M('goods_check')->add(array("stringmd5"=>$goods_cmd5,"goodsid"=>$goodid));
            //商品内容表
            M('goods_content')->add(array("goodsid"=>$goodid,"content"=>$content,"resource_url"=>$source_url));
           
            //商品参数开始===========================
            foreach($attrs as $para => $value){
              if(empty($para) or empty($value)){
                continue;
              }
              $name = $para;
              $goods_param = '';
              $goods_param = M('goods_param')->where(array("name"=>$name))->find();
              if(!$goods_param){//新增param
                $paraid = M('goods_param')->add(array("param"=>$name));
              }
              /*else{//修改catids
                $paraid = $goods_param['paraid'];
                $catids_arr = explode(",",$goods_param['catids']);
                if(!in_array($catid,$catids_arr)){
                  $catids_arr = array_merge($catids_arr,array($catid));
                  $catids_str = implode(",",$catids_arr);
                  M('goods_param')->where(array("paraid"=>$paraid))->save(array("catids"=>$catids_str));
                }
                
              }*/
              //添加参数值
              $value_id = M('goods_value')->add(array("paraid"=>$paraid,"value"=>$value,'goodsid'=>$goodid));
              //商品参数结束===========================
            }
            echo "success";
          }else{
            echo "产品添加失败";
            die();
          }
        }else{
          echo "产品已经存在";
        }
        //5 产品添加结束===============================
        /*==================数据添加或修改结束============================*/
    }
    
    //资源
    public function makeResource($resource){
      if(empty($resource))
      {
        return ;
      }
      $arrres_type = array('RT_manual','RT_catalog','RT_datasheet','RT_size','RT_torque','RT_wire');
      $model_resource = array();
      if(!empty($resource)){
        $arr_resource = explode("||",$resource);
        foreach($arr_resource as $v){
          $v = explode("=>",$v);
          list($res_name,$source,$dtype,$res_type) = $v;
          if(!empty($res_name) and !empty($source) and !empty($dtype)){
            if(empty($res_type)){
              $res_type = 'RT_manual';
            }
            $res_name = getstr(trim($res_name),150,1,1,1);
            $dtype = trim($dtype);
            $res_type = trim($res_type);
            
            if(!in_array($res_type,$arrres_type)){
              return array('tag'=>0,'message'=>'资源类型出错注意大小写');
            }
            $model_resource[] = array("res_name"=>$res_name,"resource"=>$source,"dtype"=>$dtype,"res_type"=>$res_type);
          }else{
            return array('tag'=>0,'message'=>'资源数据格式存在错误');
          }
        }
        
      }
      return array('tag'=>1,'message'=>$model_resource);
  }

  //精确匹配分类
  public function exactMatchCategory($catname){
    $catname = trim($catname);
    $category = M('category')->where(array('cat_name'=>$catname))->find();
    if(!empty($category))
    {
      return array('tag'=>1,'message'=>$category);
    }
    return array('tag'=>0,'message'=>'匹配不到分类信息');
  }

  public function addBrand($brandname,$brand_resource,$upload_path)
  {
    $brandname = preg_replace("/[^0-9a-z\-\.\& ]/i"," ",$brandname);
    $brandname = preg_replace("/[\s]+/i"," ",$brandname);
    $brandname = trim($brandname);
    $findBrand = M('brand')->where(array('brand_name'=>$brandname))->find();
    if(!empty($findBrand))//修改资源
    {
        if(empty($brand_resource))
        {
            return array('tag'=>0,'message'=>$findBrand);
        }else{
            $resids = '';
            $resid_str = '';
            $res_ids = $this->addResource($brand_resource,$upload_path);
            if(!empty($res_ids['resids']))
            {
               $resids = explode(',',$findBrand['resids']);
               $resids = array_merge($resids,$res_ids['resids']);
               $resids = array_unique($resids);
               $resid_str = implode(',',$resids);
               M('brand')->where(array('brandid'=>$findBrand['brandid']))->save(array('resids'=>$resid_str));
            }
            return array('tag'=>1,'message'=>$findBrand,'note'=>$res_ids['message']);
        }

    }else{//新增品牌
        $addtime = time();
        if(!empty($brand_resource))
        {
            $res_ids = $this->addResource($brand_resource,$upload_path);
            $resid_str = '';
            if(!empty($res_ids['resids']))
            {
               $resids = explode(',',$findBrand['resids']);
               $resids = array_merge($resids,$res_ids['resids']);
               $resids = array_unique($resids);
               $resid_str = implode(',',$resids);
            }
            $brandid = M('brand')->add(array("brand_name"=>$brandname,"addtime"=>$addtime,"resids"=>$resid_str));
            $brand = M('brand')->where(array('brandid'=>$brandid))->find();
            return array('tag'=>1,'message'=>$brand,'note'=>$res_ids['message']);
        }else{
            $brandid = M('brand')->add(array("brand_name"=>$brandname,"addtime"=>$addtime));
            $brand = M('brand')->where(array('brandid'=>$brandid))->find();
            return array('tag'=>0,'message'=>$brand);
        }
    }
  }

  public function addResource($model_resource,$upload_path){
    $res_ids = array();
    $message_arr = array();
    if(empty($model_resource))
    {
      return false;
    }
    foreach($model_resource as $value){
      $thumb_cmd5 = md5($value['resource']);
      $find_resource = M('resource_check')->where(array("cmd5"=>$thumb_cmd5))->find();
      if(!$find_resource){
        if($value['dtype'] == 'download'){
            $resource = str_replace($upload_path,"",$this->pdf_download($value['resource'],$upload_path));
            $resid = '';
            if($resource['tag'] == 1)
            {
                $resid = M("resource")->add(array("res_type"=>$value['res_type'],"res_name"=>$value['res_name'],"resource"=>$resource['message']));

                M("resource_check")->add(array("resource_url"=>$value['resource'],"stringmd5"=>$thumb_cmd5,"resid"=>$resid));
                $message = "新增加pdf资源地址:".$resid;
            }else{
              $resid = M("resource")->add(array("res_type"=>$value['res_type'],"res_name"=>$value['res_name'],"resource"=>$value['resource']));

              $message = "资源pdf采集失败:".$resid;
            }
        }else{
          
          $resid = M("resource")->add(array("res_type"=>$value['res_type'],"res_name"=>$value['res_name'],"resource"=>$value['resource']));
          M("resource_check")->add(array("resource_url"=>$value['resource'],"stringmd5"=>$thumb_cmd5,"resid"=>$resid));
          $message = "新增加外部Link资源地址:".$resid;
        }
      }else{
        $resid = $find_resource['resid'];
        $message = "下载资源已经存在".$resid;
      }
      if($resid){
        $res_ids[] = $resid;
      }
      $message_arr[] = $message;
      
    }
    return array('resids'=>$res_ids,'message'=>$message_arr);
  }

  //下载大文件不直接保存到内存，直接以数据流保存的硬盘上
  function pdf_download($url,$path="./Images/"){
    $org_name = explode("/",$url);
    $org_name = array_pop($org_name);
    $org_name = preg_replace("/\?.*/i","",$org_name);
    $fext = explode(".",$org_name);
    $fext = array_pop($fext);
    $time = time();

    $new_name =  $time.md5(uniqid(mt_rand(1000,9999))).".".$fext;
    
    $path = $path.'resource'.'/';
    $year = date("Y",$time);
    $path = $path.$year.'/';
    $path = $this->make_file($path);
    $month = date("m",$time);
    $path = $path.$month.'/';
    $path = $this->make_file($path);
    $day = date("d",$time);
    $path = $path.$day.'/';
    $path = $this->make_file($path);

    $filename = $path.$new_name;
    
    $tp = fopen($filename,'a');
    
    $curl = curl_init($url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($curl,CURLOPT_TIMEOUT,300);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl,CURLOPT_FILE,$tp);
    curl_exec($curl);
    $errno = curl_errno($curl);
    $status_code = curl_getinfo($curl,CURLINFO_HTTP_CODE);
    $err_message = curl_error($curl);
    curl_close($curl);
    
    if($errno or $status_code != 200){
      return array('tag'=>0,'message'=>$err_message);
    }
    fclose($tp);
    return array('tag'=>1,'message'=>$filename);
  }
  /*建文件*/
  public function make_file($filepath)
  {
      if(!file_exists($filepath))
      {
         mkdir($filepath,0777,true);
      }
      return $filepath;
  }
  /*保存图片
  *$type 0 将图片保存在goods下面，1保存在brand下面
  **/
  function img_download($url,$path="./Images/",$type=0){
    $curl = curl_init($url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($curl,CURLOPT_TIMEOUT,30);
    //不对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    //从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    $imageData = curl_exec($curl);
    $errno = curl_errno($curl);
    $err_message = curl_error($curl);
    $status_code = curl_getinfo($curl,CURLINFO_HTTP_CODE);
    curl_close($curl);

    $org_name = explode("/",$url);
    $org_name = array_pop($org_name);
    $org_name = preg_replace("/\?.*/i","",$org_name);
    $fext = explode(".",$org_name);
    $fext = array_pop($fext);
    $time = time();

    $new_name =  $time.md5(uniqid(mt_rand(1000,9999))).".".$fext;
    if($type == 0)
    {
       $path = $path.'goods'.'/';
    }else{
       $path = $path.'brand'.'/';
    }
    $year = date("Y",$time);
    $path = $path.$year.'/';
    $path = $this->make_file($path);
    $month = date("m",$time);
    $path = $path.$month.'/';
    $path = $this->make_file($path);
    $day = date("d",$time);
    $path = $path.$day.'/';
    $path = $this->make_file($path);

    $filename = $path.$new_name;

    if($errno or $status_code != 200){
      return array('tag'=>0,'message'=>$err_message,'imagePath'=>'default');
    }

    $tp = fopen($filename,'a');
    fwrite($tp, $imageData);
    fclose($tp);
    return array('tag'=>1,'imagePath'=>$filename);
  }
  /*添加系列*/
  function addSeries($series_name,$thumb,$content,$series_resource,$upload_path){
    $brandid = $this->brandid;
    $catid = $this->catid;
    $companyid = $this->companyid;
    
    $series = M('series')->where(array("brandid"=>$brandid,"catid"=>$catid,"series_name"=>$series_name))->find();
    if(!$series){//新增加系列
      $message = "新增加系列:";
      $createdata['series_name'] = $series_name;
      /*$createdata['letter'] = strtoupper(substr($catname,0,1));
      $createdata['linkurl'] = preg_replace("/[^0-9a-z]/i","-",$catname);
      $createdata['linkurl'] = preg_replace("/(-)+/i","-",$createdata['linkurl']);*/
      $createdata['thumb'] = $thumb;
      // $createdata['child'] = 0;
      $createdata['brandid'] = $brandid;
      $createdata['catid'] = $catid;
      $seriesid = M('series')->add($createdata);

      if($seriesid){
          $message = "新增加系列:".$seriesid;
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
      if(empty($series['companyids'])){
        $arr_companyids = array();
      }else{
        $arr_companyids = explode(",",$series['companyids']);
      }
    }
    //系列资源
    /*$res_ids = $this->addResource($series_resource,$upload_path);
    $res_ids = array_merge($arr_companyids,$res_ids);
    if(!empty($res_ids)){
      $resids = implode(",",$arr_resids);
      $this->db->update("brand_category",array("resids"=>$resids),array("bcatid"=>$bcatid));
    }*/
    return array('seriesid'=>$seriesid,'message'=>$message);
  }

}