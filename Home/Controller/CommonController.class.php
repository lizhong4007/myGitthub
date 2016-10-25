<?php
namespace tyreWWW\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function _initialize()
	{
		//导航
		$navigation = D('Navigation')->getNavigationList(array('is_show = 1'));
		$this->assign('navigation',$navigation['data']);
	}

}