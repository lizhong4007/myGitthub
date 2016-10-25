<?php
namespace tyreManage\Controller;
use Think\Controller;
/**
* @HQtag: Series operation
*/
class SeriesController extends CommonController {
	/**
	* @HQtag: Series List
	*/
    public function seriesList(){
        $series_model = D('Series');
        $searchData = trim(I('post.seriesname',''));
        $p=(int)I('p',1);;
        $size = 20;
        $where = array();
        if(!empty($searchData))
        {
            $this->assign('seriesname',$searchData);
            $where = "seriesid = "."'".$searchData."' or ";
            $searchData = "'%".$searchData."%'";
            $where .= "series_name like ".$searchData." or series_alias like ".$searchData;
        }
        $data = $series_model->getSeriesList($where,$p,$size);
        //分类
        $category = array();
        $category = D('Category')->getCategoryList();
        $this->assign('category',$category);

        $this->assign('data',$data['data']);
        $this->assign('page',$data['page']);
        $this->display('Series/SeriesList');
    }
    /**
    * @HQtag: 添加系列
    */
    public function addSeries(){
        $save = I('post.save','');
        if(!empty($save)){
            $message = '';
            if(md5($save) == '43781db5c40ecc39fd718685594f0956')
            {
                $data = I('post.data','');
                //公司
                if(empty($data['companyid']))
                {
                    echo json_encode(array("code"=>0,"message"=>L('COMPANY').L('ADMIN_NOTEMPTY')));
                    die;
                }else{
                    $data['companyids'] = $data['companyid'];
                    unset($data['companyid']);
                }
                //英文名
                if(empty($data['series_alias']))
                {
                    echo json_encode(array("code"=>0,"message"=>L('ADMIN_LANGUAGE_NAME').L('ADMIN_NOTEMPTY')));
                    die;
                }
                //图片
                if(empty($data['thumb']))
                {
                    echo json_encode(array("code"=>0,"message"=>L('ADMIN_IMAGE').L('ADMIN_NOTEMPTY')));
                    die;
                }
                //生成缩略图
                /*$thumb = $data['thumb'];
                $org_thumb = make_thumb($thumb);
                $data['thumb'] = $org_thumb;
                $data['org_thumb'] = $thumb;*/
                $series_model = D('Series');
                $result = '';
                $result = $series_model->addSeries($data);
                if(!$result)
                {
                    $message = $series_model->error;
                    echo json_encode(array("code"=>0,"message"=>$message));
                    die;
                }else{
                    echo json_encode(array("code"=>1,"message"=>L('ADMIN_ADD').L('ADMIN_SUCCESS')));
                    die;
                }
                
            }
        }
        //顶级分类
        $top_category = array();
        $top_category = D("Category")->getCategoryByParentid();
        $this->assign('top_category',$top_category);
        //品牌
        $brandid = I("get.brandid",'');
        $brand = array();
        $brand = D("Brand")->getBrand($brandid);
        $this->assign('brand',$brand);
        //公司
        $company = array();
        $company = D("Company")->getCompanyData(array("_string"=>"find_in_set('{$brandid}',brandids)"));
        $this->assign('company',$company);
        // print_r($company);exit;
        $this->assign('data',$data);
        $this->display('Series/AddSeries');

    }
    /*下级分类*/
    public function getSubCategory()
    {
        $parent_catid = I("post.parent_catid",'');
        $parent_catid = intval($parent_catid);
        $sub_category = array();
        if($parent_catid > 0)
        {
            $sub_category = D("Category")->getCategoryByParentid($parent_catid);
            if($sub_category)
            {
                echo json_encode(array("code"=>1,"sub_category"=>$sub_category));
                die;
            }
        }
        echo json_encode(array("code"=>0));
        die;
    }
    /**
    * @HQtag: 修改系列
    */
    public function updateSeries(){
        $save = I('post.save','');
        if(!empty($save)){
            $message = '';
            if(md5($save) == '43781db5c40ecc39fd718685594f0956')
            {
                $data = I('post.data','');
                //英文名
                if(empty($data['series_alias']))
                {
                    echo json_encode(array("code"=>0,"message"=>L('ADMIN_LANGUAGE_NAME').L('ADMIN_NOTEMPTY')));
                    die;
                }
                //图片
                if(empty($data['thumb']))
                {
                    echo json_encode(array("code"=>0,"message"=>L('ADMIN_IMAGE').L('ADMIN_NOTEMPTY')));
                    die;
                }
                if(empty($data['seriesid']))
                {
                    echo json_encode(array("code"=>0,"message"=>L('ADMIN_SERIES').L('ADMIN_NOEXISTED')));
                    die;
                }
                $series_model = D('Series');
                $result = '';
                $result = $series_model->updateSeries($data,$data['seriesid']);
                if(!$result)
                {
                    $message = $series_model->error;
                    echo json_encode(array("code"=>0,"message"=>$message));
                    die;
                }else{
                    echo json_encode(array("code"=>1,"message"=>L('ADMIN_UPDATE').L('ADMIN_SUCCESS')));
                    die;
                }
            }
        }
        //基本数据
        $seriesid = intval(I('seriesid',''));
        $series = array();
        $series_model = D('Series');
        $series = $series_model->getSeries($seriesid);
        $this->assign('data',$series);
        //内容
        $content = '';
        $content = $series_model->getSeriesContent($seriesid);
        $this->assign('content',$content);
        $this->display('Series/UpdateSeries');
    }
    /**
    * @HQtag: 添加系列花纹
    */
    public function addSeriesTread(){
        $seriesid = '';
        $save = I('post.save','');
        $M_series = D('Series');
        if(!empty($save)){
            $message = '';
            if(md5($save) == '43781db5c40ecc39fd718685594f0956')
            {
                $seriesid = (int)I('post.series_id','');
                $thumb = I('post.thumb','');
                $content = I('post.content','');

                foreach ($thumb as $key => $value) {
                    $data = array();
                    if(!empty($value))
                    {
                        $data['local_thumb'] = $value;
                        $data['content'] = $content[$key];
                        $data['seriesid'] = $seriesid;
                        $M_series->addSeriesResource($data);
                    }
                }
                $this->success(L('ADMIN_HANDLE').L('ADMIN_SUCCESS'),U('Series/seriesList'));
                die;
            }
        }
        $seriesid = (int)I('get.seriesid','');
        $series = $M_series->getSeries($seriesid);
        $this->assign('series',$series);
        $this->display('Series/addSeriesTread');
    }
}