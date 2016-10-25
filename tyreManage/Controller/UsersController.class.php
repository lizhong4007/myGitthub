<?php
namespace tyreManage\Controller;
use Think\Controller;
/**
* @HQtag: Users operation
*/
class UsersController extends CommonController {
	/**
	* @HQtag: Users List
	*/
	public function usersList()
	{
		$where=array('1');
		$p=(int)I('p',1);;
		$size = 20;
		$rs = D('Users')->getUsersList($where,$p,$size);
		$group = D('Groups')->getGroupsList();
		$this->assign('group',$group);
		$this->assign('data',$rs['data']);
		$this->assign('page',$rs['page']);
		$this->display('Users/UsersList');
	}
    
    /**
	* @HQtag: add Users 
	*/
	public function addUsers()
	{		
		$register = I('post.register','');
		$user_model = D('Users');
		if(!empty($register))
		{
			$data = I('post.data','');
			if(empty($data['name']))
			{
				$this->error(L('ADMIN_NAME').L('ADMIN_NOTEMPTY'));
			}
			$data['user_name'] = $data['name'];
			unset($data['name']);
			$userid = $data['mid'];
			unset($data['mid']);
			$rs = '';
			if(empty($userid))
			{
				$user = D('Users')->getUsersData(array('user_name'=>$data['name']));
				if(!empty($user))
				{
					$this->error(L('ADMIN_NAME').L('ADMIN_EXISTED'));
				}
				if(empty($data['password']))
				{
					$this->error(L('ADMIN_PASSWORD').L('ADMIN_NOTEMPTY'));
				}
				$rs = $user_model->addUsers($data);
			}else{
				$rs = $user_model->updateUsers($data,$userid);
			}
			if($rs)
			{
				$this->success(L('ADMIN_SUCCESS'),U('Users/UsersList'));
				exit;
			}else{
				$error = $user_model->error;
				$error = !$error ? L('ADMIN_FAILED') : $error;
				$this->error($error);
			}
		}
		$group = D('Groups')->getGroupsList();
		$this->assign('group',$group);
		$mid = I('get.mid','');
		$info = $user_model->getUsers($mid);
		// print_r($info);exit;
		$this->assign('data',$info);
		$this->display('Users/Register');
	}

	/**
	* @HQtag: delete Users
	*/
	public function deleteUsers()
	{
		$mid = $_GET['mid'];
		if(!empty($mid))
		{
			$rs = D('Users')->delUsers($mid);
			if(!empty($rs))
			{
				$this->success(L('ADMIN_SUCCESS'),U('Users/UsersList'));
				exit;
			}else{
				$this->error(L('ADMIN_FAILED'));
			}
		}
	}
}