<?php
namespace TyreManage\Controller;
use Think\Controller;
/**
* @HQtag: Series operation
*/
class ModelController extends CommonController {
	/**
	* @HQtag: model List
	*/
    public function modelList(){
        $model_model = D('Model');
        $searchData = trim(I('post.modelname',''));
        $p=(int)I('p',1);;
        $size = 20;
        $where = array();
        if(!empty($searchData))
        {
            $this->assign('modelname',$searchData);
            $where = "modelid = "."'".$searchData."' or ";
            $searchData = "'%".$searchData."%'";
            $where .= "model_name like ".$searchData." or linkurl like ".$searchData;
        }
        $data = $model_model->getModelList($where,$p,$size);
        $this->assign('data',$data['data']);
        $this->assign('page',$data['page']);
        $this->display('Model/ModelList');
    }

    /**
    * @HQtag: add model
    */
    public function addModel(){
        $save = I('post.save','');
        if(!empty($save)){
            $message = '';
            if(md5($save) == '43781db5c40ecc39fd718685594f0956')
            {
                $data = array();
                $data['brandid'] = I('post.brandid','');
                $data['catid'] = I('post.catid','');
                $data['companyid'] = I('post.companyid','');
                $data['seriesid'] = I('post.seriesid','');
                
                $data['thumb'] = I('post.thumb','');
                $data['org_thumb'] = I('post.org_thumb','');
                $data['official'] = I('post.official','');
                /*$data['org_thumb'] = '/Images/series/2016/10/14/1476449897_9977.png';
                $data['thumb'] = '/Images/thumb/2016/10/14/1476449897_9977.png';
                $data['official'] = 'http://www.dunlop.com.cn/products_detail_1505.html';
                $data['brandid'] = 5;
                $data['catid'] = 20;
                $data['companyid'] = 3;
                $data['seriesid'] = 60;*/

                $data['model_name'] = I('post.model','');
                $data['is_enhance'] = (int)I('post.is_enhance','');
                $data['is_import'] = (int)I('post.is_import','');
                //品牌
                if(empty($data['brandid']))
                {
                    echo json_encode(array("code"=>0,"message"=>L('ADMIN_BRAND').L('ADMIN_NOTEMPTY')));
                    die;
                }else{
                    $brand = array();
                    $brand = D('Brand')->getBrand($data['brandid']);
                    if(!$brand)
                    {
                        echo json_encode(array("code"=>0,"message"=>L('ADMIN_BRAND').L('ADMIN_NOEXISTED')));
                        die;
                    }
                }
                //公司
                if(empty($data['companyid']))
                {
                    echo json_encode(array("code"=>0,"message"=>L('COMPANY').L('ADMIN_NOTEMPTY')));
                    die;
                }else{
                    $company = array();
                    $company = D('Company')->getCompany($data['companyid']);
                    if(!$company)
                    {
                        echo json_encode(array("code"=>0,"message"=>L('COMPANY').L('ADMIN_NOEXISTED')));
                        die;
                    }
                }
                //分类
                if(empty($data['catid']))
                {
                    echo json_encode(array("code"=>0,"message"=>L('ADMIN_CAT').L('ADMIN_NOTEMPTY')));
                    die;
                }else{
                    $category = array();
                    $category = D('Category')->getCategory($data['catid']);
                    if(!$category)
                    {
                        echo json_encode(array("code"=>0,"message"=>L('COMPANY').L('ADMIN_NOEXISTED')));
                        die;
                    }
                }
                //系列
                if(empty($data['seriesid']))
                {
                    echo json_encode(array("code"=>0,"message"=>L('ADMIN_SERIES').L('ADMIN_NOTEMPTY')));
                    die;
                }
                //型号
                if(empty($data['model_name']))
                {
                    echo json_encode(array("code"=>0,"message"=>L('ADMIN_MODEL').L('ADMIN_NOTEMPTY')));
                    die;
                }
                //图片
                if(empty($data['thumb']))
                {
                    echo json_encode(array("code"=>0,"message"=>L('ADMIN_IMAGE').L('ADMIN_NOTEMPTY')));
                    die;
                }
                //1添加型号
                $model = array();
                $model['brandid'] = $data['brandid'];
                $model['catid'] = $data['catid'];
                $model['seriesid'] = $data['seriesid'];
                $model['model_name'] = $data['model_name'];
                $model['thumb'] = trim($data['thumb']);
                $model['org_thumb'] = trim($data['org_thumb']);
                $modelid = '';
                $modelid = D('Model')->addModel($model);
                if(!$modelid)
                {
                    echo json_encode(array("code"=>0,"message"=>L('ADMIN_MODEL').L('ADMIN_ADD').L('ADMIN_FAILED')));
                    die;
                }
                //2添加商品
                $goods = array();
                $goods['companyid'] = $data['companyid'];
                $goods['brandid'] = $data['brandid'];
                $goods['catid'] = $data['catid'];
                $goods['seriesid'] = $data['seriesid'];
                $goods['modelid'] = $modelid;
                $goods['brand'] = $brand['brand_name'];
                $goods['model'] = trim($data['model_name']);
                $goods['thumb'] = trim($data['thumb']);
                $goods['org_thumb'] = trim($data['org_thumb']);
                $goods['is_import'] = $data['is_import'];
                $goods['is_enhance'] = $data['is_enhance'];
                $goods['content'] = array('resource_url'=>$data['official']);
                $goods['currency'] = 'RMB';
                $title = $brand['brand_name']." ".$category['cat_name']." ".$goods['model'];
                $catname_str = preg_replace('/[^a-zA-Z0-9]/', '-', $category['cat_alias']);
                $brandname_str = preg_replace('/[^a-zA-Z0-9]/', '-', $brand['brand_alias']);
                $en_title = $brandname_str." ".$catname_str." ".$goods['model'];//英文名
                $goods['title'] = $title;
                $goods['en_title'] = $en_title;
                $goodsid = D('Goods')->addGoods($goods);
                if(!$goodsid)
                {
                    echo json_encode(array("code"=>0,"message"=>L('ADMIN_GOODS').L('ADMIN_ADD').L('ADMIN_FAILED')));
                    die;
                }
                //3添加商品参数
                $param = I('post.param','');
                $param_value = I('post.value','');
                $M_param = D('GoodsParam');
                $M_param_value = D('GoodsValue');
                foreach ($param as $key => $value) {
                    if(!empty($value) and !empty($param_value[$key]))
                    {
                        $paraid = '';
                        $paraid = $M_param->addGoodsParam(array('param'=>$value));
                        if($paraid)
                        {
                            $g_para_v = array();
                            $g_para_v['paraid'] = $paraid;
                            $g_para_v['goodsid'] = $goodsid;
                            $g_para_v['value'] = $param_value[$key];
                            $M_param_value->addGoodsValue($g_para_v);
                        }
                    }
                }
                echo json_encode(array("code"=>1));
                die;
            }
        }
        //顶级分类
        $top_category = array();
        $top_category = D("Category")->getCategoryByParentid();
        $this->assign('top_category',$top_category);
        //品牌
        // $brandid = I("get.brandid",'');
        $brandid = 8;
        $brand = array();
        $brand = D("Brand")->getBrandData(array('brandid'=>$brandid));
        // dump($brand);exit;
        $this->assign('brand',$brand);
        //公司
        $company = array();
        $company = D("Company")->getCompanyData(array("_string"=>"find_in_set('{$brandid}',brandids)"));
        $this->assign('company',$company);
        // print_r($company);exit;
        $this->assign('data',$data);
        $this->display('Model/addModel');

    }
    /*获取系列数据*/
    public function getSeries()
    {
        $brandid = intval(I('post.brandid',''));
        $catid = intval(I('post.parent_catid',''));
        $series = array();
        $series = D('Series')->getSeriesData(array('brandid'=>$brandid,'catid'=>$catid));
        if($series)
        {
            echo json_encode(array('code'=>1,'data'=>$series));
            die;
        }else{
            echo json_encode(array('code'=>0));
            die;
        }
    }
    
}