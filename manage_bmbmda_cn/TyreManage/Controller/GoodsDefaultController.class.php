<?php
namespace TyreManage\Controller;
use Think\Controller;
/**
* @HQtag: 默认参数
*/
class GoodsDefaultController extends CommonController {
	/**
	* @HQtag: 默认参数列表
	*/
	public function goodsDefaultParamList()
	{
		//分类
        $category = array();
        $category = D('Category')->getCategoryList();
        $this->assign('category',$category);

		$data  = array();
		$where = $this->Search();
		$p = (int)I('p',1);;
		$size = 20;
		$data = D('GoodsDefault')->getDefaultParamList($where,$p,$size);
		$this->assign('data',$data['data']);
		$this->assign('page',$data['page']);
        $this->display('GoodsDefault/GoodsDefaultParamList');
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
	* @HQtag: 添加默认参数
	*/
	public function addGoodsDefaultParam()
	{
		$M_default = D('GoodsDefault');
		$save = I('post.save','');
        if(!empty($save)){
            $message = '';
            if(md5($save) == '43781db5c40ecc39fd718685594f0956')
            {
                $data['param'] = I('post.param','');
				$data['catid'] = I('post.catid','');
				$data['en_param'] = I('post.en_param','');
				$data['dparaid'] = I('post.dparaid','');
				$param = '';
				$param = $M_default->addDefaultParam($data);
				if(!empty($param))
				{
					echo json_encode(array('code'=>1,'message'=>L('ADMIN_HANDLE').L('ADMIN_SUCCESS')));
	                exit;
				}else{
					$error = $M_default->error;
					$error = !$error ? L('ADMIN_HANDLE').L('ADMIN_FAILED') : $error;
					echo json_encode(array('code'=>0,'message'=>$error));
					exit;
				}
                
            }
        }
		//顶级分类
        $top_category = array();
        $top_category = D("Category")->getCategoryByParentid();
        $this->assign('top_category',$top_category);

        $data = array();
        $dparaid = I('get.dparaid','');
        $data = $M_default->getDefaultParam($dparaid);

		$this->assign('data',$data);
        $this->display('GoodsDefault/AddGoodsDefaultParam');
	}
	
    /*添加默认参数值*/
    public function addGoodsDefaultValue(){
    	$M_default = D('GoodsDefault');
    	//保存默认参数值
    	$save = I('post.save','');
        if(!empty($save)){
            $message = '';
            if(md5($save) == '43781db5c40ecc39fd718685594f0956')
            {
                $value = I('post.value','');
				$dvid = I('post.dvid','');
				$save_dparaid = (int)I('post.dparaid','');
				if(!empty($save_dparaid))
				{
					foreach ($value as $key => $v) {
						if(empty($v))
						{
							continue;
						}
						$tmp = array();
						if(empty($dvid[$key]))
						{
							$tmp = array('dparaid'=>$save_dparaid,'value'=>$v);
						}else{
							$tmp = array('dparaid'=>$save_dparaid,'value'=>$v,'dvid'=>$dvid[$key]);
						}
						$M_default->addDefaultValue($tmp);
					}
				}
				echo json_encode(array('message'=>''));
	            exit;
            }
        }
    	$dparaid = I('dparaid','');
    	//默认参数
    	$param_data = array();
    	$param_data = $M_default->getDefaultParam($dparaid);
    	$this->assign('param_data',$param_data);
        //默认参数值
    	$value_data = array();
    	$value_data = $M_default->getGoodsDefaultValue($dparaid);
    	$this->assign('value_data',$value_data);
        $this->display('GoodsDefault/AddGoodsDefaultValue');

    }
}