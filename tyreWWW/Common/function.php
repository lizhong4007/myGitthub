<?php
 /*保存图片
  *$type 0 将图片保存在goods下面，1保存在brand下面
  **/
function img_download($url,$path="./Images/",$type = ''){
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
    if(empty($type))
    {
       $path = $path.'goods'.'/';
    }else{
       $path = $path.$type.'/';
    }
    $year = date("Y",$time);
    $path = $path.$year.'/';
    $path = make_file($path);
    $month = date("m",$time);
    $path = $path.$month.'/';
    $path = make_file($path);
    $day = date("d",$time);
    $path = $path.$day.'/';
    $path = make_file($path);

    $filename = $path.$new_name;

    if($errno or $status_code != 200){
      return array('code'=>0,'message'=>$err_message,'imagePath'=>'default');
    }

    $tp = fopen($filename,'a');
    fwrite($tp, $imageData);
    fclose($tp);
    return array('code'=>1,'imagePath'=>$filename);
  }
 /*建文件*/
 function make_file($filepath)
 {
      if(!file_exists($filepath))
      {
         mkdir($filepath,0777,true);
      }
      return $filepath;
  }