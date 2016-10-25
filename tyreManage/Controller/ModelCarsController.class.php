<?php
namespace tyreManage\Controller;
use Think\Controller;
class ModelCarsController extends CommonController {
    public function modelCarsList(){
    	$series_model = D('ModelCars');
        $searchData = trim(I('post.modelcarsname',''));
        $p=(int)I('p',1);;
        $size = 20;
        $where = array();
        if(!empty($searchData))
        {
            $str = '';
            $this->assign('modelcarsname',$searchData);
            $str .= "seriesid = "."'".$searchData."' or ";
            $str .= "brandid = "."'".$searchData."' or ";
            $str .= "modelid = "."'".$searchData."' or ";
            $str .= "companyid = "."'".$searchData."' or ";
            $str .= "id = "."'".$searchData."' or ";
            $str .= "series_name like '%".$searchData."%' or ";
            $str .= "brand_name  like '%".$searchData."%' or ";
            $str .= "model_name like '%".$searchData."%' or ";
            $str .= "company_name like '%".$searchData."%'";
            $where = $str;
        }
        $data = $series_model->getModelCarsList($where,$p,$size);

        $this->assign('data',$data['data']);
        $this->assign('page',$data['page']);
        $this->display('Cars/ModelCarsList');

    }
}