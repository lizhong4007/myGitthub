<?php
namespace Common\Model;
use \Think\Model;
/**
 * 分组模型model
 * @package sample
 * @subpackage classes
 */
class GroupsModel extends Model
{
	/**
	 * 功能：获取分组列表，存入缓存
	 * @return array 分组信息
	 */
	public function getGroupsList(){
		$Groupslist = S('Groupslist');
		if(empty($Groupslist)){
			$Groupslist = array();
			$data = $this->order('groupid DESC')->select();
			foreach ($data as $value) {
				$value['permissions'] = explode(',', $value['permissions']);
				$Groupslist[$value['groupid']] = $value;
			}
			S('Groupslist',$Groupslist);
		}
		return $Groupslist;
	}
	/**
	 * 功能：添加和修改分组
	 * 清除分组缓存数据
	 * @param array $data 添加数据
	 * @return bool
	 */
	public function addGroups($data = array())
	{
		if(empty($data['groupid']))
		{
			$rs = $this->add($data);
		}else{
			$Groupid = $data['groupid'];
			unset($data['groupid']);
			$rs = $this->where('groupid='.$Groupid)->save($data);
		}
		S('Groupslist',NULL);
		return $rs;
	}
    /**
     * 功能：根据条件查询所有分组
     * 将权限分割成数组
     * @param  array  $where 
     * @return bool | 分组信息
     */
	public function getGroups($where = array())
	{
		 $rs = $this->where($where)->find();
		 if(empty($rs)) return;
		 $rs['permissions'] = explode(',', $rs['permissions']);
		 return $rs;
	}

	/**
	 * 功能：根据分组id删除分组
	 * 清除分组缓存数据
	 * @param  int $groupid 分组id
	 * @return bool 
	 */
	public function deleteGroups($groupid = 0)
	{
		$groupid = intval($groupid);
		if($groupid <= 0) return false;
		S('Groupslist',NULL);
		return $this->where('groupid='.$groupid)->delete();
	}
}
