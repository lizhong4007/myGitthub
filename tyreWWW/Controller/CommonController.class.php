<?php
namespace TyreWWW\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function _initialize()
	{
		//导航
		$navigation = D('Navigation')->getNavigationList(array('is_show = 1'));
		$this->assign('navigation',$navigation['data']);


		//图片地址
		$site = C('BM_SITE');
		$this->assign('site_imagedomain',$site['UPLOAD_FILE_URL']);
		$this->assign('default_image',$site['DEFAULT_IMAGE']);
		$this->assign('default_site',$site['DEFAULT_SITE']);
		$this->assign('default_title',$site['DEFAULT_TITLE']);
	}
	function _empty(){ 
		header("HTTP/1.0 404 Not Found");//使HTTP返回404状态码 
		$this->display("Public:404"); 
	} 

}