<?php
namespace TyreWWW\Controller;
use Think\Controller;
/**
*功能：只传入系列，公司，型号数据
*型号是表格形式，系列外部添加
*添加后传入系列id
*/
class CoopertireController extends Controller {
    private $brandid = 13;
    private $brand_name = '锦湖';
    private $catid = 0;
    private $seriesid = 2128;
    private $seriesid_other;
    private $series_name = '';
    private $companyid = '10';
    private $company_name = '锦湖 ';
    private $thumb = '';
    private $org_thumb = '';
    private $thumb2 = '';
    private $thumb3 = '';

    private $modelid;
    private $goodsid;
    private $model;
    private $error;
    private $source_url;
    private $upload_path;
    private $series_content;
    public function index()
    {
        error_reporting(E_ALL);
        ini_set('max_execution_time', 900);

        $upload_path = APP_PATH.'/Images/';
        $this->upload_path = $upload_path;

        //数据来源地址 地址手动写
        // $source_url = I("source_url",'');
        $source_url = I("brandname",'');
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
          }
          $this->source_url = $source_url;
        }

        


        //分类
        /*$cat_name = trim(I("catname",''));
        $cat_name = intval($cat_name);
        $Category = M('Category')->where(array('catid'=>$cat_name))->find();
        if(empty($Category) or empty($cat_name))
        {
          echo '分类不存在';
          die;
        }else{
          $this->catid = $Category['catid'];
        }*/

        //品牌
        /*$brand_name = trim(I("brandname",''));
        $brand_info = M('Brand')->where(array('brand_name'=>$brand_name))->find();
        if(empty($brand_info) or empty($brand_name))
        {
          echo '品牌不存在';
          die;
        }else{
          $this->brandid = $brand_info['brandid'];
          $this->brand_name = $brand_info['brand_name'];

          $company = M('Company')->where(array('companyid'=>$this->companyid))->find();
          $brandids = explode(',', $company['brandids']);
          $brandid = $brand_info['brandid'];
          if(!in_array($brandid, $brandids))
          {
             echo($brand_name.'请将该品牌添加到该公司'.$company['company_name']);
             die;
          }
        }*/

        //添加系列
        /*$series_name = trim(I("series",''));
        if(empty($series_name))
        {
          echo "系列名称不能为空";
          die;
        }
        else{
          if(!preg_match('/[0-9a-zA-Z]/',$series_name))
          {
            echo '系列名称格式不正确';
            die;
          }
        }*/

        $thumb_url = trim(I("thumb",''));
        /*if(empty($thumb_url))
        {
          echo "图片不能为空";
          die;


        }*/

        /*查询系列*/
        $series_info = array();
        $series_link = preg_replace('/[^0-9a-zA-Z]/','-',$series_name);
        $series_link = preg_replace('/(-)+/','-',$series_link);
        // $series_info = M('series')->where(array('linkurl'=>$series_link,'brandid'=>$this->brandid,'catid'=>$this->catid))->find();
        $series_info = M('series')->where(array('seriesid'=>$this->seriesid))->find();
        $series_data = array();
        if(!empty($series_info))
        {
          /*$series_data = array();
          M('series')->where(array('seriesid'=>$series_info['seriesid']))->save(array('thumb'=>$this->thumb,'org_thumb'=>$this->org_thumb,'thumb2'=>$series_info['thumb2']));*/
            $this->thumb = $series_info['thumb'];
            $this->org_thumb = $series_info['org_thumb'];
            $this->thumb2 = $series_info['thumb2'];
            $this->thumb3 = $series_info['thumb3'];
            $this->catid = $series_info['catid'];
            $this->series_name = $series_info['series_name'];
            $this->seriesid = $series_info['seriesid'];
            $this->brandid = $series_info['brandid'];
        }
        else{
              //图片
              $thumb_url = trim(I("thumb",''));
              if(!empty($thumb_url))
              {
                /*echo "图片不能为空";
                die;*/

                $thumb_arr_tmp = array();
                $thumb_arr_tmp = explode('||', $thumb_url);

                $thumb_arr0 = array();
                $thumb_arr0 = $this->img_download($thumb_arr_tmp[0],'./Images/','series');

                if($thumb_arr0['code'] == 0)
                {
                  echo "图片添加失败";
                  echo $thumb_arr0['message'];
                  die;
                }else{
                    $thumb_org = '';
                    $thumb_org = $thumb_arr0['imagePath'];
                    $thumb = $this->thumb_suo($thumb_org,'series');//缩略图
                    $thumb_org = preg_replace('/.\/Images\//', '/Images/', $thumb_org);
                    $this->thumb = $thumb;
                    $this->org_thumb = $thumb_org;
                }

              }


              if(!empty($thumb_arr_tmp[1]))
              {   $thumb_arr1 = array();
                  $thumb_arr1 = $this->img_download($thumb_arr_tmp[1],'./Images/','series');
                  if($thumb_arr1['code'] != 0)
                  {
                    $thumb_org2 = preg_replace('/.\/Images\//', '/Images/', $thumb_arr1['imagePath']);
                      $this->thumb2 = $thumb_org2;
                  }
              }

              if(!empty($thumb_arr_tmp[2]))
              {   $thumb_arr2 = array();
                  $thumb_arr2 = $this->img_download($thumb_arr_tmp[2],'./Images/','series');

                  if($thumb_arr2['code'] != 0)
                  {
                    $thumb_org3 = preg_replace('/.\/Images\//', '/Images/', $thumb_arr2['imagePath']);
                      $this->thumb3 = $thumb_org3;
                  }
              }
                   /* // 系列内容
                    $series_content = trim(I("series_content",''));
                    $series_content = preg_replace('/( )/', ' ', $series_content);
                    $series_content = trim($series_content);
                    $this->series_content = $series_content;*/

                    
                    $series_alias = preg_replace('/[^0-9a-zA-Z\-]/',' ',$series_name);
                    $series_alias = preg_replace('/( )+/',' ',$series_alias);
                    $series_data_tmp = array('series_name'=>$series_alias,'series_alias'=>$series_alias);
                    $rs = $this->addSeries($series_data_tmp);
                    if(!$rs)
                    {
                      echo "系列添加失败";
                      die;
                    }
                  
              }
        

        //  // 系列内容
        /*$series_content = trim(I("series_content",''));
        $series_content = preg_replace('/( )/', ' ', $series_content);
        $series_content = trim($series_content);
        $content_language = 1;
        $this->add_series_content($series_content,$content_language);*/
 // M("check_site")->add(array("cmd5"=>$source_url_cmd5,"source_url"=>$source_url));
        $model_str = I('model','');

        if(empty($model_str))
        {
          echo '型号名称不能为空';
          die;
        }
      

        
       
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

                if(count($model_arr_td[1]) != 13)
                {
                  echo 13;
                  die;
                }
               
                //型号

                  $XL = 0;
                  $model_arr_td_2 = '';
                  $model_arr_td_2 = $model_arr_td[1][0];
                  $model_arr_td_2 = preg_replace('/(\/)+/','/',$model_arr_td_2);
                  $model_arr_td_2 = str_replace(' ','',$model_arr_td_2);
                  $model_arr_td_2 = trim($model_arr_td_2);
                  if(!empty($model_arr_td_2))
                  {
                    if(preg_match('/XL/', $model_arr_td_2))
                    {
                       $XL = 1;
                       $model_arr_td_2 = preg_replace('/XL/', '', $model_arr_td_2);
                    }
                    if(preg_match('/LT/', $model_arr_td_2))
                    {
                       $XL = 3;
                       $model_arr_td_2 = preg_replace('/LT/', '', $model_arr_td_2);
                    }
                    if(preg_match('/EL/', $model_arr_td_2))
                    {
                       $XL = 2;
                       $model_arr_td_2 = preg_replace('/EL/', '', $model_arr_td_2);
                    }
                  }
                  $model_arr_td_3 = '';
                  $model_arr_td_3 = $model_arr_td[1][0];
                  $model_arr_td_3 = preg_replace('/(\/)+/','/',$model_arr_td_3);
                  $model_arr_td_3 = str_replace(' ','',$model_arr_td_3);
                  $model_arr_td_3 = trim($model_arr_td_3);
                  /*$model_arr_td_3_arr = array();
                  $model_arr_td_3_arr = explode(' ',$model_arr_td_3);
                  $model_arr_td_3 = $model_arr_td_3_arr[0];*/
                  $model_arr_td_3 = preg_replace('/LT/', '', $model_arr_td_3);
                  $model_arr_td_3 = preg_replace('/-8PR/', '', $model_arr_td_3);
                  $model_arr_td_3 = preg_replace('/P/', '', $model_arr_td_3);
                  $model_arr_td_3 = preg_replace('/\/C/', '', $model_arr_td_3);
                  $model_arr_td_3 = preg_replace('/C/', '', $model_arr_td_3);
                  $model_arr_td_3 = preg_replace('/ST/', '', $model_arr_td_3);
                  $model_arr_td_3 = preg_replace('/\+/', '', $model_arr_td_3);
                  $model_arr_td_3 = trim($model_arr_td_3);
                  $this->addModel($model_arr_td_3,$seriesid);

                    //是否进口
                  $is_import = 0;
                  // if(preg_match('/\*/', $model_arr_td[1][3]))
                  // {
                  //   $is_import = 2;
                  // }
                  // if(preg_match('/\□/', $model_arr_td[1][3]))
                  // {
                  //   $is_import = 1;
                  // }

                  $is_innertyre = 0;
                  /*if(preg_match('/TL/', $model_arr_td[1][2]))
                  {
                    $is_innertyre = 1;
                  }

                  if(preg_match('/TT/', $model_arr_td[1][2]))
                  {
                    $is_innertyre = 2;
                  }*/

                  $is_flat = 0;
                 /* if(preg_match('/SSR/', $model_arr_td[1][7]))
                  {
                    $is_innertyre = 1;
                  }*/
                  
                  //产品
                  $goods = array();
                  $goods['is_enhance'] = $XL;
                  $goods['is_import'] = $is_import;
                  $goods['language'] = 1;
                  $goods['is_flat'] = $is_flat;
                  $goods['is_innertyre'] = $is_innertyre;
                  $this->addGoods($goods);

                  //参数
                  //
                  

                  /*if(!empty($model_arr_td[1][1]))
                  {
                     $lianbu = '';
                     $lianbu = preg_replace('/[^0-9]/','',$model_arr_td[1][1]);
                     $LR = '';
                     $LR = preg_replace('/[^a-zA-Z]/','',$model_arr_td[1][1]);

                     $this->addGoodSpec(array('LR'=>$LR));

                     $this->addGoodSpec(array('帘布层评级'=>$lianbu));
                     $this->addDefaultParam('帘布层评级',$lianbu);
                  }*/
                  
                  $bian_str = '';
                  $bian_str = $model_arr_td[1][2];
                  if(!empty($bian_str))
                  {
                     $bian_str = preg_replace('/[^0-9\/]/','',$bian_str);
                     $fuzhong = array();
                     $fuzhong = explode('/', $bian_str);
                     if(empty($fuzhong[1]))
                     {
                       $bian_str = $fuzhong[0];
                     }
                     $this->addGoodSpec(array('帘布层评级'=>$bian_str));
                     $this->addDefaultParam('帘布层评级',$bian_str);
                     // $this->addGoodSpec(array('负重指数'=>$bian_str));

                  }

                   $sudu = '';
                  $sudu = $model_arr_td[1][2];
                  if(!empty($sudu))
                  {
                    $sudu_arr = array();
                    $sudu_arr = explode(' ', $sudu);
                    $sudu = array_pop($sudu_arr);
                    if(preg_match('/PR/'))
                    {
                      $sudu_arr = array();
                      $sudu_arr = explode('PR',$sudu);
                      $sudu = $sudu_arr[1];
                    }
                     $sudu = preg_replace('/[^a-zA-Z]/','',$sudu);
                     $sudu = strtoupper($sudu);
                     $sudu = substr($sudu, 0,1);
                     $this->addGoodSpec(array('速度级别'=>$sudu));
                     $this->addDefaultParam('速度级别',$sudu);
                  }
                
                      

                  if(preg_match('/\//',$model_arr_td_3))
                  {
                    if(!preg_match('/\*/',$model_arr_td_3) and preg_match('/R/',$model_arr_td_3))
                    {
                      $model_arr_td_3 = preg_replace('/[^0-9\.]/','&;',$model_arr_td_3);
                      $model_arr_td_3 = preg_replace('/(&;)+/','&;',$model_arr_td_3);
                      $model_arr_td_3_arr_tmp = array();
                      $model_arr_td_3_arr_tmp = explode('&;',$model_arr_td_3);

                      if(!empty($model_arr_td_3_arr_tmp[0]))
                      {
                          $this->addGoodSpec(array('胎面宽度'=>$model_arr_td_3_arr_tmp[0]));
                      }

                      if(!empty($model_arr_td_3_arr_tmp[1]))
                      {
                          $this->addGoodSpec(array('扁平率'=>$model_arr_td_3_arr_tmp[1]));
                          $this->addDefaultParam('扁平比',$model_arr_td_3_arr_tmp[1]);
                      }

                      if(!empty($model_arr_td_3_arr_tmp[2]))
                      {
                          $this->addGoodSpec(array('轮辋直径'=>$model_arr_td_3_arr_tmp[2]));
                          $this->addDefaultParam('轮辋直径',$model_arr_td_3_arr_tmp[2]);
                      }


                    }
                  }

                  if(!empty($model_arr_td[1][3]))
                  {
                    $fanwei = '';
                    $fanwei = $model_arr_td[1][3];
                    $fanwei = str_replace('1/2', '.5', $fanwei);
                    $fanwei = str_replace(' ', '', $fanwei);
                    $fanwei = trim($fanwei);
                    $fanwei_arr = array();
                    $fanwei_arr = explode('on',$fanwei);
                    $fanwei = array_pop($fanwei_arr);
                    
                    
                    $lunwan_v = '';
                    $lunwan_v = preg_replace('/[^0-9.]/','',$fanwei);
                    $lunwan_v_tmp = '';
                    $lunwan_v_tmp = number_format($lunwan_v,1);
                    if($lunwan_v - $lunwan_v_tmp != 0)
                    {
                       $lunwan_v = number_format($lunwan_v,2);
                    }else{
                       $lunwan_v = number_format($lunwan_v,1);
                    }
                    if($lunwan_v > 0)
                    {
                      $lunwan_d = '';
                      $lunwan_d = $fanwei;
                      $lunwan_d = preg_replace('/[^a-zA-Z]/','',$lunwan_d);
                      $lunwan_d = strtoupper($lunwan_d);
                      if(empty($lunwan_d))
                      {
                        $lunwan_d = "J";
                      }

                      $this->addGoodSpec(array('标准轮辋'=>$lunwan_v.$lunwan_d));
                      $this->addDefaultParam('标准轮辋',$lunwan_v.$lunwan_d);
                    }

                    
                  }

                  if(!empty($model_arr_td[1][5]))
                  {
                    $zhijing = '';
                    $zhijing = $model_arr_td[1][5];
                    $zhijing = $zhijing *25.4;
                    $this->addGoodSpec(array('轮胎外直径(mm)'=>$zhijing));
                  }

                  if(!empty($model_arr_td[1][6]))
                  {
                    $duanmian = '';
                    $duanmian = $model_arr_td[1][6];
                    $duanmian = $duanmian *25.4;
                    $this->addGoodSpec(array('断面宽度'=>$duanmian));
                  }

                  if(!empty($model_arr_td[1][7]))
                  {
                    $banjing = '';
                    $banjing = $model_arr_td[1][7];
                    $banjing = $banjing *25.4;
                    $this->addGoodSpec(array('静态负载半径'=>$banjing));
                  }

                   if(!empty($model_arr_td[1][8]))
                  {
                    $dantai = '';
                    $dantai = trim($model_arr_td[1][8]);
                    $dantai_arr = array();
                    $dantai_arr = explode('@', $dantai);
                    $dantai = array_shift($dantai_arr);
                    $dantai = preg_replace('/[^0-9]/','',$dantai);
                    $dantai = trim($dantai);
                    if(!empty($dantai))
                    {
                      $dantai = number_format($dantai*0.4535923,2);
                      $this->addGoodSpec(array('最大负荷能力(单胎)'=>$dantai));
                    }
                    
                  }

                   if(!empty($model_arr_td[1][9]))
                  {
                    $shuangtai = '';
                    $shuangtai = $model_arr_td[1][9];
                    $shuangtai_arr = array();
                    $shuangtai_arr = explode('@', $shuangtai);
                    $shuangtai = array_shift($shuangtai_arr);
                    $shuangtai = preg_replace('/[^0-9]/','',$shuangtai);
                    $shuangtai = trim($shuangtai);
                    if(!empty($shuangtai))
                    {
                      $shuangtai = number_format($shuangtai*0.4535923,2);
                      $this->addGoodSpec(array('最大负荷能力(双胎)'=>$shuangtai));
                    }
                    
                  }

                  if(!empty($model_arr_td[1][10]))
                  {
                    $zhuanshu = '';
                    $zhuanshu = $model_arr_td[1][10];
                    $zhuanshu = preg_replace('/\-/','',$zhuanshu);
                    $zhuanshu = trim($zhuanshu);
                    if(!empty($zhuanshu))
                    {
                      $this->addGoodSpec(array('转速/英里'=>$zhuanshu));
                    }
                    
                  }

                  if(!empty($model_arr_td[1][11]))
                  {
                    $this->addGoodSpec(array('花纹深度(mm)'=>$model_arr_td[1][11]));
                  }

                  if(!empty($model_arr_td[1][12]))
                  {
                    $weight = '';
                    $weight = $model_arr_td[1][12];
                    $weight = number_format($weight*0.4535923,2);
                    $this->addGoodSpec(array('轮胎重(kg)'=>$weight));
                  }

                  /*if(!empty($model_arr_td[1][3]))
                  {
                    $this->addGoodSpec(array('轮圈保护'=>$model_arr_td[1][3]));
                  }

                  if(!empty($model_arr_td[1][5]))
                  {
                    $this->addGoodSpec(array('燃油效率'=>$model_arr_td[1][5]));
                  }
                  if(!empty($model_arr_td[1][6]))
                  {
                    $this->addGoodSpec(array('抓地力'=>$model_arr_td[1][6]));
                  }

                  if(!empty($model_arr_td[1][7]))
                  {
                    $this->addGoodSpec(array('噪声'=>$model_arr_td[1][7]));
                  }*/

                  //  if(!empty($model_arr_td[1][2]))
                  // {
                  //   $this->addGoodSpec(array('O.D. IN.'=>$model_arr_td[1][2]));
                  // }
                  //  if(!empty($model_arr_td[1][4]))
                  // {
                  //   $this->addGoodSpec(array('胎面宽度'=>$model_arr_td[1][4]));
                  // }

                  //  if(!empty($model_arr_td[1][5]))
                  // {
                  //   $this->addGoodSpec(array('花纹深度(mm)'=>$model_arr_td[1][5]));
                  // }


                  //  if(!empty($model_arr_td[1][7]))
                  // {
                  //   $kg = '';
                  //   $kg = number_format($model_arr_td[1][7]/0.4535924,2);
                  //   $this->addGoodSpec(array('最大负荷(kg)'=>$kg));
                  // }
                  // 
                  /*if(!empty($model_arr_td[1][4]))
                  {
                    $this->addGoodSpec(array('侧壁'=>$model_arr_td[1][4]));
                  }

                  if(!empty($model_arr_td[1][5]))
                  {
                    $this->addGoodSpec(array('UTQG'=>$model_arr_td[1][5]));
                  }

                  if(!empty($model_arr_td[1][6]))
                  {
                    $this->addGoodSpec(array('允许使用轮辋'=>$model_arr_td[1][6]));
                  }

                  
                  

                  

                  

                  

                  

                  

                  if(!empty($model_arr_td[1][15]))
                  {
                    $this->addGoodSpec(array('Max Inflation(psi)'=>$model_arr_td[1][15]));
                  }
*/
                  
                  

                


                  //车型数据
           /* $cars = $model_arr_td[1][1];
            $cars = trim($cars);
            if(!empty($cars))
            {
              $carsids = array();
              $tmp = array();
                  $tmp = explode('、',$cars);
                  foreach ($tmp as $car_tmp) {
                    if(empty($car_tmp))
                    {
                      continue;
                    }
                    $carsids[] = $this->addCars($car_tmp);
                  }
                  $carsids_str = '';
                  $carsids_str = implode(',',$carsids);
                  
                  $model_cars = array();
                  // $model_cars['model_name'] = trim($model_arr_td_3);
                  $model_cars['carsids'] = $carsids;
                  $this->addModelCars($model_cars);
            }*/

                  
              

            }
       }
      
       //系列资源
        /*$resource_thumb_str = I('resource','');
        if(!empty($resource_thumb_str))
        {
          $resource_thumb_arr =array();
          $resource_thumb_arr = explode('||',$resource_thumb_str);
          foreach ($resource_thumb_arr as $key => $value) {
            $res_tmp = array();
            $res_tmp = explode('=&gt;', $value);
            if(empty($res_tmp[1]))
            {
              $res_tmp[1] = '';
            }
            $this->dealSeriesResource($res_tmp[0],$res_tmp[1]);
          }
          
        }*/

      M("check_site")->add(array("cmd5"=>$source_url_cmd5,"source_url"=>$source_url));

       echo 'success';

      
}
//添加型号资源
public function addmodel_resource($model_resource)
{
    $modelid = $this->modelid;

     //型号处理
     $model_info = array();
     $model_info = M('model')->where(array('modelid'=>$modelid))->find();
     if(empty($model_info))
     {
      return;
     }
    $cmd5 = md5($model_resource);
    $resid = '';
    $info = array();
    $info = M('resource')->where(array('cmd5'=>$cmd5))->find();
    if(!empty($info))
    {
      $resid = $info['resid'];
    }else{

      $thumb = array();
      $thumb = $this->img_download($model_resource,'./Images/','model');
      if($thumb['code'] != 0)
      {
        $thumb_org3 = '';
        $thumb_org3 = preg_replace('/.\/Images\//', '/Images/', $thumb['imagePath']);

        $resid = M('resource')->add(array('cmd5'=>$cmd5,'remark'=>'model','res_type'=>'picture','resource'=>$thumb_org3));

      }else{
        return ;
      }
      
    }
    // echo $resid;

    
     if(!empty($model_info['resids']))
     {
         $resids = $model_info['resids'].','.$resid;
         $resids_arr = explode(',',$resids);
         foreach ($resids_arr as $key => $value) {
           if(empty($value))
           {
             unset($resids_arr[$key]);
           }
         }
         $resids_arr = array_unique($resids_arr);
         $resid = implode(',',$resids_arr);
     }
     M('model')->where(array('modelid'=>$modelid))->save(array('resids'=>$resid));
}
/**
* 创建文件
*/
private function make_file($file)
{
    if(!file_exists($file))
    {
        mkdir($file);
    }
}
//缩略图$imagePath 图片地址，$type保存文件夹
private function thumb_suo($imagePath,$type)
{

      $image = new \Think\Image(); 
      $image->open(APP_PATH.$imagePath);
      // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
      $thumb_path = str_replace($type, 'thumb', $imagePath);
      $thumb_path_arr = explode('/', $thumb_path);
      $y_file = APP_PATH.'/Images/thumb/'.$thumb_path_arr[3];
      $this->make_file($y_file);
      $m_file = $y_file.'/'.$thumb_path_arr[4];
      $this->make_file($m_file);
      $d_file = $m_file.'/'.$thumb_path_arr[5];
      $this->make_file($d_file);
      $thumb_name = $d_file.'/'.$thumb_path_arr[6];
      $image->thumb(300, 300)->save($thumb_name);
      $thumb_name = str_replace(APP_PATH, '', $thumb_name);
      return $thumb_name;
}

/*默认参数*/
private function addDefaultParam($param,$value)
{
  $value = trim($value);
  $value = preg_replace('/[^a-zA-Z0-9\.]/', '', $value);
  $param = trim($param);
  $goodsid = $this->goodsid;
  if(empty($param) or empty($value) or empty($goodsid))
  {
      return;
  }
  $value = strtolower($value);
  $d_param = array();//默认参数表
  $d_param = M('goods_default_para')->where(array('param'=>$param))->find();
  if(empty($d_param))
  {
    return;
  }

  $d_value = array();//默认参数值表
  $value = strtolower($value);
  $d_value = M('goods_default_value')->where(array('value'=>$value,'dparaid'=>$d_param['dparaid']))->find();
  if(empty($d_value))
  {
    return;
  }
  $f_param = array();//默认参数筛选表
  $data = array(
    'dparaid'=>$d_param['dparaid'],
    'dvid'=>$d_value['dvid'],
    'goodsid'=>$goodsid
    );
  $f_param = M('goods_filter_param')->where($data)->find();
  if(!empty($f_param))
  {
    return;
  }
  M('goods_filter_param')->add($data);


}

/*添加车型和型号匹配数据表,model carsids为string
*/
private function addModelCars($model_cars = array())
{
    if(is_array($model_cars['carsids']))
    {
      $model_cars['carsids'] = implode(',', $model_cars['carsids']);
    }
    /*$model_cars['brandid'] = $this->brandid;
    $model_cars['brand_name'] = $this->brand_name;*/
    $model_cars['seriesid'] = $this->seriesid;
    $model_cars['companyid'] = $this->companyid;
    $model_cars['company_name'] = $this->company_name;
    $series_info = array();
    $series_info = D('Series')->getSeries($model_cars['seriesid']);
    $model_cars['series_name'] = $series_info['series_name'];
    $catid = $series_info['catid'];
    $model_cars['brandid'] = $series_info['brandid'];
    //品牌
    $brand_info = array();
    $brand_info = D('Brand')->getBrand($model_cars['brandid']);
    if(!$brand_info)
    {
       echo  "品牌不存在";
       die;
    }
    $model_cars['brand_name'] = $brand_info['brand_name'];

    $modelid = 0;
    $model_name = $this->model;
    $model_cars['model_name'] = $this->model;
    $model_info = '';
    $model_info = M('Model')->where(array('model_name'=>$model_name,'brandid'=>$model_cars['brandid'],'seriesid'=>$model_cars['seriesid'],'catid'=>$catid))->find();
    if($model_info)
    {
       $model_cars['modelid'] = intval($model_info['modelid']);
    }
    $tmp_where = $model_cars;
    unset($tmp_where['carsids']);
    $info = '';
    $info = M('model_cars')->where($tmp_where)->find();
    if($info)
    {
      $str = array();
      $str_tmp = '';
      $model_carsids_tmp = array();
      $model_carsids_tmp = explode(',',$model_cars['carsids']);
      if(!empty($info['carsids']))
      {
         $str = explode(',', $info['carsids']);
         $model_carsids_tmp = array_merge($str,$model_carsids_tmp);
      }
      $model_carsids_tmp = array_unique($model_carsids_tmp);

      $str_tmp = implode(',',$model_carsids_tmp);

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
   // $car_name = get_substr($car_name,100);
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
       echo  "型号名称不能为空";
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
    $thumb2 = $this->thumb2;
    $thumb3 = $this->thumb3;
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
        $model_data['thumb2'] = $thumb2;
        $model_data['thumb3'] = $thumb3;
        $model_data['org_thumb'] = $org_thumb;
        $model_data['addtime'] = TIMESTAMP;
        $modelid = M('model')->add($model_data);
        //型号参数开始====================
        if(!$modelid){
            echo "添加型号失败";
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
    if(empty($series_info))
    {
      echo "系列查询失败";
      die;
    }
    $catid = $series_info['catid'];
    $brandid = $series_info['brandid'];
    
    $companyid = $this->companyid;
    $company = M('company')->where(array('companyid'=>$companyid))->find();
    $company_alias = $company['company_alias'];
    $modelid = $this->modelid;
    $model = $this->model;
    $thumb = $this->thumb;
    $thumb2 = $this->thumb2;
    $thumb3 = $this->thumb3;
    $org_thumb = $this->org_thumb;
    $source_url = $this->source_url;
    //品牌
    $brand_info = array();
    $brand_info = D('Brand')->getBrand($brandid);
    if(!$brand_info)
    {
       echo  "品牌不存在";
       return false;
    }
    //分类
    $category_info = array();
    $category_info = D('Category')->getCategory($catid);
    if(empty($category_info))
    {
       echo "分类不存在";
       die;
    }
    //产品标题处理
    $title = '';
    if(empty($goods['title'])){
      $title = $brand_info['brand_name']." ".$category_info['cat_name']." ".$model;
    }else{
      $title = $goods['title'];
    }
    $catname_str = preg_replace('/[^a-zA-Z0-9\-]/', '-', $category_info['cat_alias']);
    $brandname_str = preg_replace('/[^a-zA-Z0-9\-]/', '-', $brand_info['brand_alias']);
    $en_title = $brandname_str." ".$catname_str." ".$model;//英文名
    $en_title = preg_replace('/(-)+/', '-', $en_title);

        // dump($title);
        //检查产品是否存在
        $check_title = $title.$company_alias.$seriesid;
        $goods_cmd5 = md5($check_title);
        $goods_check_info = array();
        $goods_check_info = M('goods_check')->where(array('stringmd5'=>$goods_cmd5))->find();
        if(empty($goods_check_info))
        {
            /*===检查产品是否存在开始=========================*/
            $find_goods = array();
            $find_goods = M('goods')->where(array("modelid"=>$modelid,"companyid"=>$companyid,"seriesid"=>$seriesid))->find();
            if(empty($find_goods)){//新增产品

                $goods_linkurl = preg_replace("/[^a-zA-Z0-9]/","-",$en_title.$company_alias);
                $goods_linkurl = preg_replace("/(-)+/","-",$goods_linkurl);
                $goods['title'] = $title;
                $en_title = preg_replace('/[^0-9a-zA-Z\-\.\/]/', ' ', $en_title);
                $en_title = trim($en_title);
                $goods['en_title'] = strtolower($en_title);
                $goods['linkurl'] = strtolower($goods_linkurl);
                $goods['thumb'] = $thumb;
                $goods['thumb2'] = $thumb2;
                $goods['thumb3'] = $thumb3;
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
                echo  "产品添加失败";
                return false;
              }
            }else{
              $this->goodsid = $find_goods['goodsid'];
            }
        }else{
            $this->goodsid = $goods_check_info['goodsid'];
        }
        echo "产品已经存在";
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
      $this->addGoodSpecSingle($key,$value);
    }
}
/*添加单条商品参数*/
public function addGoodSpecSingle($param,$value)
{
    $this->error = '';
    $goodsid = $this->goodsid;
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
      $thumb = $this->thumb2;
      $thumb2 = $this->thumb;
      $thumb3 = $this->thumb3;
      $org_thumb = $this->org_thumb;
      $series = array();
      $seriesid = $this->seriesid;
      $series_content = M('series_content')->where(array('seriesid'=>$seriesid))->find();
      $seriesid_other = '';
      $series = M('Series')->where(array("brandid"=>$brandid,"catid"=>$catid,"series_alias"=>$createdata['series_alias']))->find();
      if(!$series){//新增加系列
         
          $createdata['thumb'] = $thumb;
          $createdata['thumb2'] = $thumb2;
          $createdata['thumb3'] = $thumb3;
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
              echo "新增系列:缺气保用轮胎";
              $this->seriesid_other = $seriesid_other;
              return ture;
          }else{
              echo  "新增系列失败";
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
            echo "更新系列:companyids{$companyids_str}";
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
      $thumb2 = $this->thumb2;
      $thumb3 = $this->thumb3;
      $org_thumb = $this->org_thumb;
      $series_content = $this->series_content;
      $series = array();
      $seriesid = '';
      $series_info = M('Series')->where(array("brandid"=>$brandid,"catid"=>$catid,"series_name"=>$createdata['series_name']))->find();
      if(!$series_info){//新增加系列
          
          $createdata['thumb'] = $thumb;
          $createdata['thumb2'] = $thumb2;
          $createdata['thumb3'] = $thumb3;
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
              // echo "新增系列:缺气保用轮胎";
              $this->seriesid = $seriesid;
              return ture;
          }else{
              echo  "新增系列失败";
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
  /*添加系列内容*/
  public function add_series_content($content,$language = 0)
  {
    if(empty($content))
    {
      return;
    }
    $seriesid = $this->seriesid;
    $info =  array();
    $info = M('series_content')->where(array('seriesid'=>$seriesid))->find();
    if(!empty($info))
    {
      M('series_content')->where(array('scid'=>$info['scid']))->save(array('content'=>$content,'language'=>$language));
    }else{
      M('series_content')->add(array('content'=>$content,'seriesid'=>$seriesid,'language'=>$language));
    }
  }
 /**
   * 处理添加系列花纹资源,单条记录添加，
   * @param  string $image_url 原始路径
   * @param  string $title     标题
   * @param  string $content   内容描述
   * @return [type]            [description]
   */
  private function dealSeriesResource($image_url = '',$content = '',$title = '')
  {
    $seriesid = $this->seriesid;
         //型号处理
     $series_info = array();
     $series_info = M('series')->where(array('seriesid'=>$seriesid))->find();
     if(empty($series_info))
     {
      return;
     }
    $cmd5 = md5($image_url);
    $resid = '';
    $info = array();
    $info = M('resource')->where(array('cmd5'=>$cmd5))->find();
    if(!empty($info))
    {
      $resid = $info['resid'];
    }else{

      $thumb = array();
      $thumb = $this->img_download($image_url,'./Images/','resource');
      if($thumb['code'] != 0)
      {
        $thumb_org3 = '';
        $thumb_org3 = preg_replace('/.\/Images\//', '/Images/', $thumb['imagePath']);

        $resid = M('resource')->add(array('cmd5'=>$cmd5,'remark'=>'series','res_type'=>'picture','resource'=>$thumb_org3));

      }else{
        return ;
      }
      
    }
    // echo $resid;

    
     if(!empty($series_info['resids']))
     {
         $resids = $series_info['resids'].','.$resid;
         $resids_arr = explode(',',$resids);
         foreach ($resids_arr as $key => $value) {
           if(empty($value))
           {
             unset($resids_arr[$key]);
           }
         }
         $resids_arr = array_unique($resids_arr);
         $resid = implode(',',$resids_arr);
     }
     M('series')->where(array('seriesid'=>$seriesid))->save(array('resids'=>$resid));
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

    /*保存图片
  *$type 0 将图片保存在goods下面，1保存在brand下面
  **/
function img_download($url,$path="./Images/",$type = ''){

    $url = preg_replace('/ /', '%20', $url);
    $cmd5 = md5($url);
    $info = M('check_thumb')->where(array('cmd5'=>$cmd5))->find();
    if(!empty($info))
    {
       return array('code'=>1,'imagePath'=>$info['local_thumb']);
    }
   
    // $useragent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0';
    // $cookie = 'JSESSIONID=93DF7E1AC9809671BC571CEC9262393C; Hm_lvt_6633023fba65b8f170f647ffe6178b82=1480339175; Hm_lpvt_6633023fba65b8f170f647ffe6178b82=1480339195';
    $header[] = 'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
    $header[] = "Accept-Language:zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3";
    $header[] = "Connection:keep-alive";
    $header[] = "Host:blobs.barum-tyres.com";
    $header[] = "Accept-Encoding:gzip, deflate, br";
    $header[] = 'Upgrade-Insecure-Requests:1';
    $header[] = 'If-None-Match:"57b22bd5ceb2099953640229b5b7856"';
      $imageData = '';
      $errno = '';
      $err_message = '';
      $status_code = '';
      $curl = curl_init($url);
      // curl_setopt($curl, CURLOPT_USERAGENT, $useragent);
    // curl_setopt($curl, CURLOPT_COOKIE, $cookie);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($curl,CURLOPT_TIMEOUT,300);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    // curl_setopt($curl, CURLOPT_POST, true);
    // curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    // echo $url;
    $imageData = curl_exec($curl);
    $errno = curl_errno($curl);
    $status_code = curl_getinfo($curl,CURLINFO_HTTP_CODE);
    $err_message = curl_error($curl);
    curl_close($curl);
   
 

    $org_name = explode("/",$url);
    $org_name = array_pop($org_name);
    // $org_name = preg_replace("/\?.*/i","",$org_name);
    $fext = explode(".",$org_name);
    $fext = array_pop($fext);
    // $fext = preg_replace('/\!360/', '', $fext);
    $fext_arr = array('gif','jpg','jpeg','png');
    if(!in_array($fext, $fext_arr))
    {
       echo '图片后缀不对';
       die;
    }
    $time = time();

    $new_name =  $time.md5(uniqid(mt_rand(1000,9999))).".".$fext;
    if(empty($type))
    {
       $path = $path.'goods'.'/';
    }else{
       $path = $path.$type.'/';
    }
    // $path = APP_PATH.$path;
    $year = date("Y",$time);
    $path = $path.$year.'/';
    $path = $this->make_file1($path);
    $month = date("m",$time);
    $path = $path.$month.'/';
    $path = $this->make_file1($path);
    $day = date("d",$time);
    $path = $path.$day.'/';
    $path = $this->make_file1($path);

    $filename = $path.$new_name;
    // $filename = preg_replace('/\!360/', '', $filename);

    if($errno or $status_code != 200){
      echo $err_message;
      return array('code'=>0,'message'=>$err_message,'imagePath'=>'default');
    }
    // echo $filename;echo "<br />";

    $tp = fopen($filename,'a');
    fwrite($tp, $imageData);
    fclose($tp);

    $thumb_tmp = preg_replace('/.\/Images\//', '/Images/', $filename);
    M('check_thumb')->add(array('resource'=>$url,'cmd5'=>$cmd5,'local_thumb'=>$thumb_tmp));
    return array('code'=>1,'imagePath'=>$filename);
  }

   /*建文件*/
 function make_file1($filepath)
 {
      if(!file_exists($filepath))
      {
         mkdir($filepath,0777,true);
      }
      return $filepath;
  }

}