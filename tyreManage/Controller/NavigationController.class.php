<?php
namespace tyreManage\Controller;
use Think\Controller;
/**
* @HQtag: Navigation operation
*/
class NavigationController extends CommonController {
	/**
	* @HQtag: Navigation List
	*/
	public function navigationList()
	{
		$data  = array();
		$serarch = I('searched','');
		$where = array();
		if(!empty($serarch) and md5($serarch) == '8ae282bece4a312bbc5595c60eedc0e6')
		{
			$nav_name = I('post.nav_name','');
			$nav_name = trim($nav_name);
			if(!empty($nav_name))
			{
			   $where[] = "`nav_name` like '%".$nav_name."%' or `controller` like '%".$nav_name."%' or `navid` = '".$nav_name."' or `action` like'%".$nav_name."%'";  
			}
			$this->assign('nav_name',$nav_name);
		}
		$p = (int)I('p',1);;
		$size = 20;
		$data = D('Navigation')->getNavigationList($where,$p,$size);
		$this->assign('data',$data['data']);
		$this->assign('page',$data['page']);
        $this->display('Navigation/NavigationList');
	}
	
	/**
	* @HQtag: add Navigation
	*/
	public function addNavigation()
	{
		/*保存品牌*/
		$save = I('post.save','');
		$nav_model = D('Navigation');
		if(!empty($save)){
			if(md5($save) == '43781db5c40ecc39fd718685594f0956')
			{
				$data['nav_name'] = I('post.nav_name','');
				$data['controller'] = I('post.controller','');
				$data['action'] = I('post.action','');
				$navid = I('post.navid','');
				$navigation = '';
				if(empty($navid))//新增品牌
				{
					$navigation = $nav_model->addNavigation($data);
				}else{//修改品牌
					$navigation = $nav_model->updateNavigation($data,$navid);
				}
				if($navigation)
				{
					echo json_encode(array('code'=>1,'message'=>L('ADMIN_HANDLE').L('ADMIN_SUCCESS')));
	                exit;
				}else{
					$error = $nav_model->error;
					$error = !$error ? L('ADMIN_HANDLE').L('ADMIN_FAILED') : $error;
					echo json_encode(array('code'=>0,'message'=>$error));
					exit;
				}
			}
		}
		/*品牌初始信息*/
		$navid = I('get.navid','');
		$data = array();
		if(!empty($navid))
		{
			$data = $nav_model->getNavigation($navid);
		}
		$this->assign('data',$data);
        $this->display('Navigation/EditNavigation');
	}
	/**
	* @HQtag: delete Navigation
	*/
    public function deleteNavigation()
	{
		$navid = I('get.navid','');
		if(empty($navid) or $navid <= 0)
		{
			$this->error(L('ADMIN_FAILED'));
			exit;
		}
		$result = '';
		$result = D('Navigation')->deleteNavigation($navid);
		if($result)
		{
			$this->success(L('ADMIN_DELETE').L('ADMIN_SUCCESS'),U('Navigation/NavigationList'));
            exit;
		}else{
			$this->error(L('ADMIN_DELETE').L('ADMIN_FAILED'));
			exit;
		}
	}
	/*update Category is_recommend*/
    public function ajaxUpdate()
    {
        $navid = I('navid','');
        $state = I('state','');
        $data['is_show'] = $state == 1 ? 0 : 1;
        $rs = D('Navigation')->updateNavigation($data,$navid);
        if(!empty($rs))
        {
            $result['code'] = 1;
        }else{
            $result['code'] = 0;
        }
        $result['state'] = $data['is_show'];
        echo json_encode($result); 
        die; 
    }
}