<?php
namespace Common\Model;
use \Think\Model;
/**
 * 用户模型model
 * @package sample
 * @subpackage classes
 */
class UsersModel extends Model
{
	public $error = '';
	/**
	 * 功能：获取用户列表
	 * @param  array   $where [条件]
	 * @param  integer $p     [起始页]
	 * @param  integer $size  [每页显示数量]
	 * @param  string  $order [排序]
	 * @return array   查询结果
	 */
	public function  getUsersList($where = array('1'),$p = 0,$size = 20,$order = 'log_last_time DESC')
	{
		$count = $this->where($where)->count();
        $pages = pages($count,$p,$size);
        $result = $this->where($where)->page($p,$size)->order($order)->select();
        $data['data'] = $result;
        $data['page'] = $pages;
		return $data;
	}
	/**
	 * 功能：添加和修改用户
	 * @param array $data 传入数据
	 * @return  userid 用户id
	 */
	public function addUsers($data = array())
	{
		if(isset($data['userid']))
		{
			unset($data['userid']);
		}
		if(empty($data['user_name']))
		{
			$this->error = L('ADMIN_NAME').L('ADMIN_NOTEMPTY');
			return false;
		}
		$data = $this->dealUsers($data);
		if(!$data)
		{
			return false;
		}
		$user = '';
		$user = $this->getUsersData(array('user_name'=>$data['user_name']));
		if(!empty($user))
		{
			$this->error = L('ADMIN_NAME').L('ADMIN_EXISTED');
			return false;
		}
		$ip = get_client_ip();
		$data['reg_ip'] = ip2long($ip);
		$data['reg_time'] = TIMESTAMP;
		return $this->add($data);
	}
	/**
	 * 功能：添加和修改用户
	 * @param array $data 传入数据
	 * @param int $userid 用户id
	 * @return  userid 用户id
	 */
	public function updateUsers($data = array(),$userid = 0)
	{
		$user = intval($userid);
		if(empty($data) or $userid <= 0) return false;
		$info = $this->getUsers($userid);
		if(!$userid)
		{
			$this->error = L('ADMIN_NAME').L('ADMIN_NOEXISTED');
			return false;
		}
		$user = '';
		$data = $this->dealUsers($data);
		if(!$data)
		{
			return false;
		}
		if(!empty($data['user_name']))
		{
			$user = $this->getUsersData(array('user_name'=>$data['user_name']));
			if(!empty($user))
			{
				if($user[0]['userid'] != $userid)
				{
					$this->error = L('ADMIN_NAME').L('ADMIN_EXISTED');
					return false;
				}
			}
		}
		if(isset($data['userid']))
		{
			unset($data['userid']);
		}
		$result = '';
		$result = $this->where('userid='.$userid)->save($data);
		if($result)
		{
			return $userid;
		}else{
			return false;
		}
	}
	/**
     * 功能：处理用户数据
     * @param  array  $data 用户数据
     * @return false | array 用户数据        
     */
	public function dealUsers($data = array())
	{
		if(empty($data)) return false;
		if(!empty($data['user_name']))
		{
			$data['user_name'] = trim(substr($data['user_name'], 0,20));
		}
		if(!empty($data['password']))
		{
			$reg =  '/^[a-zA-Z]+[0-9a-zA-Z\_@]{5,15}$/';
			if(!preg_match($reg, $data['password']))
			{
				$this->error = L('ADMIN_PASSWORD').L('ADMIN_LETTERS');
				return false;
			}
			$data['password'] = password($data['password']);
		}
		if(!empty($data['telephone']))
		{
			$data['telephone'] = trim(substr($data['telephone'], 0,30));
		}
		if(!empty($data['email']))
		{
			$data['email'] = trim(substr($data['email'], 0,50));
		}
		if(!empty($data['qq']))
		{
			$data['qq'] = trim(substr($data['qq'], 0,50));
		}
		return $data;
	}
    /**
     * 功能：获取用户单条数据
     * @param  int  $userid 用户id
     * @return false | array 用户数据        
     */
	public function getUsers($userid = 0)
	{
		$userid = intval($userid);
		if($userid <= 0) return false;
		return $this->where(array('userid'=>$userid))->find();
	}
	/**
     * 功能：获取多条用户数据
     * @param  array  $where 查询条件
     * @return false | array 用户数据        
     */
	public function getUsersData($where = array())
	{
		return $this->where($where)->select();
	}
	/**
	 * 功能：删除单条用户数据
	 * @param  int $userid 用户id
	 * @return false | 影响行数
	 */
	public function delUsers($userid = 0)
	{
		$userid = intval($userid);
		if($userid <= 0 ) return false;
		return $this->where('userid='.$userid)->delete();
	}
	/**
	 * 功能：用户登录
	 * @param  string $name     
	 * @param  string $password 
	 * @return [type]           
	 */
	public function login($name = '',$password = ''){
		if(empty($name) or empty($password)) return false;
		$rs = '';
		$rs = $this->getUsersData(array('user_name'=>$name));
		if(empty($rs))
		{
			return L('ADMIN_USERNAME').L('ADMIN_NOEXISTED');
		}else{
			$rs = array_pop($rs);
			$password = password($password);
			if($password == $rs['password'])
			{
				session('managerid',$rs['userid']);
				$ip = get_client_ip();
				$ip = ip2long($ip);
				$data['log_last_time'] = TIMESTAMP;
				$data['log_last_ip'] = $ip;
				$data['userid'] = $rs['userid'];
				$this ->addUsers($data);
				redirect(U('HomePage/index'));
			}else{
				return L('ADMIN_PASSWORD').L('ADMIN_ERROR');
			}
		}
	}
}