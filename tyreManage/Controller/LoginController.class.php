<?php
namespace TyreManage\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function Index(){
        $this->display('Login/Login');
    }

    /*sign in*/
    public function Login(){
        $data = $_POST['data'];
		$name = $data['name'];
		$password = $data['password'];
        $message = '';
		if(empty($name))
		{
			$message = L('ADMIN_USERNAME').L('ADMIN_NOTEMPTY');
			$this->Message($message);
		}
		if(empty($password))
		{
			$message = L('ADMIN_PASSWORD').L('ADMIN_NOTEMPTY');
			$this->Message($message);
		}
        $rs = array();
		$rs = D('Users')->login($name,$password);
        if($rs['code'] == 0)
        {
            $message = $rs['message'];
            $this->Message($message);
        }else{
            $this->success('login success!',U('HomePage/index'));
        }
		
    }

    public function Message($message)
    {
    	$this->assign('message',$message);
		$this->display('Login/Login');
		exit;
    }
    /*login out*/
    public function Drop()
    {
    	session('managerid',null);
    	redirect(U('Login/Index'));
    }
}