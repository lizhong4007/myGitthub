<?php
namespace Common\Model;
use \Think\Model;
/**
 * 导航模型model
 * @package sample
 * @subpackage classes
 */
class NavigationModel extends Model
{
	public $error = '';
	/**
	*功能：获取导航列表
	*@param array $where
	*@param int $p 起始页
	*@param int $size 每页显示条数
	*@param string $order 排序
	*@return false | array数据和分页
	**/
	public function getNavigationList($where = array('1'),$p = 0,$size = 20,$order = 'nav_order DESC')
	{
		$data = array();
		$count = $this->where($where)->count();
        $pages = pages($count,$p,$size);
        $result = $this->where($where)->page($p,$size)->order($order)->select();
        $data['data'] = $result;
        $data['page'] = $pages;
		return $data;
	}
	/**
	*功能：添加导航
	*@param array $data
	*@return false | id
	**/
	public function addNavigation($data = array())
	{
		if(empty($data)) return false;
        //非空数据
		if(empty($data['nav_name']))
		{
			$this->error = L('NAVIGATION').L('ADMIN_NOTEMPTY');
			return false ;
		}
		if(empty($data['controller']))
		{
			$this->error = 'controller'.L('ADMIN_NOTEMPTY');
			return false ;
		}
		if(empty($data['action']))
		{
			$this->error = 'action'.L('ADMIN_NOTEMPTY');
			return false ;
		}
		$data = $this->dealNavigation($data);
		if(!$data)
		{
			return false;
		}
		// 验证导航名是否存在
		$navigation = '';
		$navigation = $this->checkNavigation($data);
		if($navigation)
		{
			$this->error = L('NAVIGATION').L('ADMIN_EXISTED');
			return false;
		}
		$navid = '';
		$navid = $this->add($data);
		if($navid)
		{
			return $navid;
		}else{
			$this->error = L('NAVIGATION').L('ADMIN_ADD').L('ADMIN_FAILED');
			return false;
		}
	}
	/**
	*功能：修改导航
	*@param array $data
	*@param int $navid 导航id
	*@return false | navid
	**/
	public function updateNavigation($data = array(),$navid = 0)
	{
		$data = $this->dealNavigation($data);
		$navid = intval($navid);
		if(empty($data) or $navid <= 0) return false;
		//验证导航是否存在
		$info = '';
		$info = $this->getNavigation($navid);
		if(!$info)
		{
			$this->error = L('NAVIGATION').L('ADMIN_NOEXISTED');
			return false;
		}
		//检查是否存在同名
		$navigation = '';
		$navigation = $this->checkNavigation($data);
		if($navigation)
		{
			if($navigation[0]['navid'] != $navid)
			{
				$this->error = L('NAVIGATION').L('ADMIN_EXISTED');
				return false;
			}
		}
		//修改
		$result = $this->where('navid='.$navid)->save($data);
		if(!empty($result))
		{
			return $navid;
		}else{
			$this->error = L('NAVIGATION').L('ADMIN_UPDATE').L('ADMIN_FAILED');
			return false;
		}
	}
	/**
	*功能：验证导航是否存在
	*@param array $data
	*@return false | array 导航信息
	**/
	private function checkNavigation($data = array())
	{
		if(empty($data)) return false;
		//组合条件
		$where = array();
		$where['controller']  = $data['controller'];
		$where['action'] = $data['action'];
		return $this->getNavigationData($where);
	}
	/**
	*功能：根据navid获取导航数据
	*@param int $navid
	*@return false | array 导航信息
	**/
	public function getNavigation($navid = 0)
	{
		$navid = intval($navid);
		return $this->where(array('navid'=>$navid))->find();
	}
	/**
	*功能：获取多条导航数据
	*@param array $where
	*@return false | array 导航信息
	**/
	public function getNavigationData($where = array())
	{
		return $this->where($where)->select();
	}
	/**
	*功能：根据navid删除导航
	*@param int $navid
	*@return false | array 导航信息
	**/
	public function deleteNavigation($navid = 0)
	{
		$navid = intval($navid);
		return $this->where(array('navid'=>$navid))->delete();
	}
    
	/**
	 * 处理导航数据
	 * @param  array $data
	 * @return false | 
	 */
	private function dealNavigation($data = array())
	{
		if(empty($data)) return false;
		//数据处理
		if(!empty($data['nav_name']))
		{
			$nav_name = get_substr($data['nav_name'],50);
			if(!$nav_name)
			{
				$this->error = L('NAVIGATION').L('TOO_LONG').'50';
				return false ;
			}else{
				$data['nav_name'] = $nav_name;
			}
		}
		//controller
		if(!empty($data['controller']))
		{
			$controller = get_substr($data['controller'],50);
			if(!$controller)
			{
				$this->error = 'controller'.L('TOO_LONG').'50';
				return false ;
			}else{
				$data['controller'] = $controller;
			}
		}
		//action
		if(!empty($data['action']))
		{
			$action = get_substr($data['action'],50);
			if(!$action)
			{
				$this->error = 'action'.L('TOO_LONG').'50';
				return false ;
			}else{
				$data['action'] = $action;
			}
		}
		if(isset($data['navid']))
		{
			unset($data['navid']);
		}
		return $data;
	}
}