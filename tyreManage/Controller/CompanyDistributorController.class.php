<?php
namespace tyreManage\Controller;
use Think\Controller;
/**
* @HQtag: companyDistributor operation
*/
class CompanyDistributorController extends CommonController {
	/**
	* @HQtag: companyDistributor List
	*/
    public function companyDistributorList(){
        $distributor_model = D('CompanyDistributor');
        $searchData = trim(I('post.companyDistributorname',''));
        $p=(int)I('p',1);;
        $size = 20;
        $where = array();
        if(!empty($searchData))
        {
            $this->assign('companyDistributorname',$searchData);
            $where = "distributorid = "."'".$searchData."' or ";
            $searchData = "'%".$searchData."%'";
            $where .= "distributor_name like ".$searchData." or address like ".$searchData;
        }
        $data = $distributor_model->getCompanyDistributorList($where,$p,$size);
        $this->assign('data',$data['data']);
        $this->assign('page',$data['page']);
        $this->display('Company/CompanyDistributorList');
    }
}