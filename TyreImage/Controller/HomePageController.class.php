<?php
namespace TyreImage\Controller;
use Think\Controller;
class HomePageController extends Controller {
    public function index(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     0 ;// 设置附件上传大小
        $upload->exts      =     array('gif','jpg','jpeg','bmp','png','pdf');// 设置附件上传类型
        // 开启子目录保存 并以日期（格式为Ymd）为子目录
        $upload->autoSub = true;
        $upload->subName = array('date','Y');
        $upload->saveName = time().'_'.mt_rand(1000,9999);
        $image_root = '/Images/';
        $upload->rootPath  =     APP_PATH.$image_root; // 设置附件上传根目录
        $type = I('type','');//上传子目录，goods，brand，resource
        $type = trim($type);
        $callback = I('callback','');
        $callback = trim($callback);
        if(empty($type))
        {
        	$upload->savePath  =     'goods'; // 设置附件上传（子）目录
        }else{
        	$upload->savePath  =     $type.'/';
        }
        // 上传文件 
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $error = $upload->getError();
            $rs = $callback.'('.json_encode(array('flag'=>0,'message'=>$error)).')';
        }else{// 上传成功
            $imagePath = $image_root.$info['Filedata']['savepath'].$info['Filedata']['savename'];
            $thumb_name = '';
            if($type != 'brand' and $type != 'resource' and $type != 'company')
            {
                //缩略图
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
            }
            $rs = $callback.'('.json_encode(array('flag'=>1,'message'=>$imagePath,'thumb'=>$thumb_name)).')';
        }
        echo($rs) ;
	    die();

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
}