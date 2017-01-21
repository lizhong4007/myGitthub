<?php
namespace TyreManage\Controller;
use Think\Controller;
/**
* @HQtag: Brand operation
*/
class BrandController extends CommonController {
	/**
	* @HQtag: Brand List
	*/
	public function brandList()
	{
		$data  = array();
		$where = $this->Search();
		$p = (int)I('p',1);;
		$size = 20;
		$data = D('Brand')->getBrandList($where,$p,$size);
		$this->assign('data',$data['data']);
		$this->assign('page',$data['page']);
        $this->display('Brand/BrandList');
	}
	/**
	 *搜索框搜索条件
	*/
	private function Search()
	{
		$serarch = I('searched','');
		$where = array();
		if(!empty($serarch) and md5($serarch) == '8ae282bece4a312bbc5595c60eedc0e6')
		{
			$brandname = I('brandname','');
			$brandname = trim($brandname);
			if(!empty($brandname))
			{
			   $where[] = "`brand_name` like '%".$brandname."%' or `brand_alias` like '%".$brandname."%' or `brandid` = '".$brandname."'";  
			}
			$this->assign('brandname',$brandname);
		}
		return $where;
	}

	/**
	* @HQtag: Add Brand
	*/
	public function addBrand()
	{
		/*保存品牌*/
		$save = I('post.save','');
		$brand_model = D('Brand');
		if(!empty($save)){
			if(md5($save) == '43781db5c40ecc39fd718685594f0956')
			{
				$data = I('post.data','');
				$brand = '';
				if(empty($data['brandid']))//新增品牌
				{
					$brand = $brand_model->addBrand($data);
				}else{//修改品牌
					$brand = $brand_model->updateBrand($data,$data['brandid']);
				}
				if($brand)
				{
					$this->success(L('ADMIN_HANDLE').L('ADMIN_SUCCESS'),U('Brand/BrandList'));
	                exit;
				}else{
					$error = $brand_model->error;
					$error = !$error ? L('ADMIN_HANDLE').L('ADMIN_FAILED') : $error;
					$this->error($error);
					exit;
				}
			}
		}
		/*品牌初始信息*/
		$brandid = I('get.brand_id','');
		$data = array();
		if(!empty($brandid))
		{
			$data = $brand_model->getBrand($brandid);
		}
		$this->assign('data',$data);
        $this->display('Brand/BrandEdit');
	}
	/**
	* @HQtag: delete Brand
	*/
    public function deleteBrand()
	{
		$brandid = I('get.brand_id','');
		if(empty($brandid) or $brandid <= 0)
		{
			$this->error(L('ADMIN_FAILED'));
			exit;
		}
		$result = '';
		$result = D('Brand')->deleteBrand($brandid);
		if($result)
		{
			$this->success(L('ADMIN_DELETE').L('ADMIN_SUCCESS'),U('Brand/BrandList'));
            exit;
		}else{
			$this->error(L('ADMIN_DELETE').L('ADMIN_FAILED'));
			exit;
		}
	}
	/*update brand is_recommend*/
    public function ajaxUpdate()
    {
        $brand_id = I('brand_id','');
        $state = I('state','');
        $data['is_recommend'] = $state == 1 ? 0 : 1;
        $rs =D('Brand')->updateBrand($data,$brand_id);
        if(!empty($rs))
        {
            $result['code'] = 1;
        }else{
            $result['code'] = 0;
        }
        $result['state'] = $data['is_recommend'];
        echo json_encode($result); 
        die; 
    }
}