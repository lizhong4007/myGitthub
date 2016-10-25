<?php
namespace tyreManage\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){

    	$data = array(
    		// "res_name"=>"1",
    		"resid"=>"2",
    		);
        /*echo intval($data['resid']);
        $resource_model = D('Resource');
    	$resource_model->addResource($data);
    	$resource_model->updateResource($data,2);
    	$resource_model->deleteResource(2);
        echo $res_check_model->error;
        exit;*/
    	
        //资源检查
        /*$res_check_model = D('ResourceCheck');
        $res_check_model -> addResourceCheck($data);
        $res_check_model -> updateResourceCheck($data,1);
        $rs = $res_check_model -> getResourceCheck(1);
        $rs = $res_check_model -> getResourceCheckData($data);
        print_r($rs);
        echo $res_check_model->error;
    	exit;*/
        
        //系列检查
       /* $series = array(
            'catid'=>'10',
            'brandid'=>'1',
            'series_name'=>'kv 4123ss1 v',
            'companyids'=>'2'
            );
        $series_model = D('Series');
        // $series_model -> addSeries($series);
        $series_model -> updateSeries($series,11);
        print_r($rs);
        echo $series_model->error;
        exit;*/

        // 型号检查
        /*$model = array(
            'catid'=>'10',
            'brandid'=>'1',
            'seriesid'=>'1',
            'model_name'=>'sd 2ss3 /ss',
            );
        $model_model = D('Model');
        // $model_model -> addModel($model);
        $model_model -> updateModel($model,3);
        echo $model_model->error;
        exit;*/
        // 品牌检查
        /*$brand = array(
            'brand_name'=>'别克1',
            'brand_alias'=>'bieke bo',
            );
        $brand_model = D('Brand');
        // $brand_model -> addBrand($brand);
        $brand_model -> updateBrand($brand,5);
        echo $brand_model->error;
        exit;*/

        // 公司检查
        /*$company = array(
            'company_name'=>'别s克1',
            'company_alias'=>'bieske bo',
            'operation_mode'=>'经营模式不能为空',
            'site'=>'http://manage.tywswre.com',
            );
        $company_model = D('Company');
        // $company_model -> addCompany($company);
        $company_model -> updateCompany($company,3);
        echo $company_model->error;
        exit;*/

        // 产品和产品内容检查 
        /*$goods = array(
            'catid'=>'1',
            'brandid'=>'1',
            'seriesid'=>'1',
            'modelid'=>'1',
            'title'=>'goods 123',
            'companyid'=>'2',
            'content'=>array('content'=>'123456'),
            );
        $goods_model = D('Goods');
        // $goods_model -> addGoods($goods);
        $goods_model -> updateGoods($goods,18);
        echo $goods_model->error;
        exit;*/
         

        // 单条产品规格参数检查
        /*$spec_param = array(
            'param'=>'guige'
            );

        $GoodsParam_model = D('GoodsParam');
        $param = $GoodsParam_model ->getGoodsParamByName($spec_param['param']);//查询规格名称是否存在
        if(!$param)
        {
            $GoodsParam_model -> addGoodsParam($spec_param);
        }
        echo $GoodsParam_model->error;

        $spec_value = array(
            'value'=>'guige',
            'paraid'=>'10',
            'goodsid'=>'10',
            );
        $GoodsValue_model = D('GoodsValue');
        $GoodsValue_model -> addGoodsValue($spec_value);
        echo $GoodsValue_model->error;
        
        exit;*/

        $this->display('Index/Index');
    }

    //首页
    public function Main(){
        // $this->display('Managers/Index');
    }
}