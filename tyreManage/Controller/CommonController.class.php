<?php
namespace TyreManage\Controller;
use Think\Controller;
class CommonController extends Controller {
	public $manager = null;
	public function _initialize()
	{
		$managerid = session('managerid');
		if(empty($managerid))
        {
        	redirect(U('Login/Index'));
        }else{
            if($managerid != 'Administrator')
            {
                $rs = D('Users')->getUsers(array('userid'=>$managerid));
                if(empty($rs))
                {
                    redirect(U('Login/Index'));
                }
                if($rs['groupid'] != 0)
                {
                   $group = D('Groups')->getGroups(array('groupid'=>$rs['groupid'])); 
                   $rs['groupname'] = $group['group_name'];
                   $rs['permissions'] = $group['permissions'];
                }
            }else{
                $rs['name'] = 'Administrator';
            }
        	$GLOBALS['manager'] = $rs;
            $this->manager = &$GLOBALS['manager'];
            if(!checkPermission()){
                $this->error(L('ADMIN_NOT').L('ADMIN_PERMISSION').L('ADMIN_HANDLE'),U('Index/Index'));
            }
        }
        $navigation = C('NAVIGATION');
        $this->assign('navigation',$navigation);
        $MANAGEMENT_MODEL = C('MANAGEMENT_MODEL');
        $this->assign('MANAGEMENT_MODEL',$MANAGEMENT_MODEL);
        $this->assign('manager',$rs);

        //图片地址
        $site = C('BM_SITE');
        $this->assign('site_imagedomain',$site['UPLOAD_FILE_URL']);
        $this->assign('default_image',$site['DEFAULT_IMAGE']);
        $this->assign('default_site',$site['DEFAULT_SITE']);
	}
	
}