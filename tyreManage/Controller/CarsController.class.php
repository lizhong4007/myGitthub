<?php
namespace tyreManage\Controller;
use Think\Controller;
class CarsController extends CommonController {
    public function carsList(){
    	$series_model = D('Cars');
        $searchData = trim(I('post.carsname',''));
        $p=(int)I('p',1);;
        $size = 20;
        $where = array();
        if(!empty($searchData))
        {
            $this->assign('carsname',$searchData);
            $where = "carid = "."'".$searchData."' or ";
            $searchData = "'%".$searchData."%'";
            $where .= "car_name like ".$searchData;
        }
        $data = $series_model->getCarsList($where,$p,$size);

        $this->assign('data',$data['data']);
        $this->assign('page',$data['page']);
        $this->display('Cars/CarsList');

    }
}