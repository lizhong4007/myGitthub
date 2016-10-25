<?php
namespace tyreManage\Controller;
use Think\Controller;
/**
* @HQtag: groups operation 
*/
class GroupsController extends CommonController{
	/**
	* @HQtag: groups list
	*/
	public function groupList()
	{
		$rs = D('Groups')->getGroupsList();
		$this->assign('data',$rs);
		$this->display('Groups/GroupList');
	}
    /**
	* @HQtag: add groups
	*/
	public function addGroup()
	{
		$save = I('post.save','');
		if(!empty($save))
		{
			$data = I('post.data','');
			if(empty($data['name']))
			{
				$this->error(L('ADMIN_GROUP').L('ADMIN_NOTEMPTY'));
			}
			$gid = $data['groupid'];
			if(empty($gid))
			{
				$group = D('Groups')->getGroups(array('group_name'=>$data['name']));
				if(!empty($group))
				{
					if($group['groupid'] != $gid)
					{
					   $this->error(L('ADMIN_GROUP').L('ADMIN_EXISTED'));
					}
				}
			}
		    $permission = I('post.permission','');
		    if(empty($permission))
		    {
		    	$this->error(L('ADMIN_PERMISSION').L('ADMIN_NOTEMPTY'));
		    }
			$data['permissions']  = implode(',', $permission);
			$data['group_name'] = $data['name'];
			unset($data['name']);
			$rs = D('Groups')->addGroups($data);
			if(!empty($rs))
			{
				$this->success(L('ADMIN_SUCCESS'),U('Groups/GroupList'));
				exit;
			}else{
				$this->error(L('ADMIN_FAILED'));
			}
		}
		$groupid = I('get.groupid','');
		$info = D('Groups')->getGroups(array('groupid'=>$groupid));
		$this->assign('data',$info);
		$this->display('Groups/GroupEdit');
	}

	/**
	* @HQtag: delete groups
	*/
	public function deleteGroup()
	{
		$groupid = I('get.groupid','');
		if(!empty($groupid))
		{
			$rs = D('Groups')->deleteGroups($groupid);
			if(!empty($rs))
			{
				$this->success(L('ADMIN_SUCCESS'),U('Groups/GroupList'));
				exit;
			}
		}
		$this->error(L('ADMIN_FAILED'));
	}
}