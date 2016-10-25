<?php
namespace tyreWWW\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function _initialize()
	{
		//导航
		$navigation = D('Navigation')->getNavigationList(array('is_show = 1'));
		$this->assign('navigation',$navigation['data']);

		//图片地址
		$site_imagedomain = C('UPLOAD_FILE_URL');
		$this->assign('site_imagedomain',$site_imagedomain);
		$default_image = C('DEFAULT_IMAGE');
		$this->assign('default_image',$default_image);
	}

}