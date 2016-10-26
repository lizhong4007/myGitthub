<?php
namespace TyreManage\Controller;
use Think\Controller;
/**
* @HQtag: Category operation
*/
class CategoryController extends CommonController {
	/**
	* @HQtag: Category List
	*/
    public function categoryList(){
        $searchData = trim(I('post.categoryname',''));
        if(!empty($searchData))
        {
            $this->assign('categoryname',$searchData);
            $where = "catid = "."'".$searchData."' or ";
            $searchData = "'%".$searchData."%'";
            $where .= "cat_name like ".$searchData." or cat_alias like ".$searchData;
            $data = D('Category')->getCategoryData($where);
        }else{
            $data = D('Category')->getCategoryList();
        }
        $this->assign('data',$data);
        $this->display('Category/CategoryList');
    }
    /**
    * @HQtag: Add Category
    */
    public function addCategory(){
        $save = I('post.save','');
        $category_model = D('Category');
        if(!empty($save))
        {
            $data = I('post.data','');
            if(empty($data['cat_name']) or empty($data['cat_alias']))
            {
                $this->error(L('ADMIN_CAT').L('ADMIN_NOTEMPTY'));
            }
            $cat_id = '';
            $cat_id = $data['cat_id'];
            unset($data['cat_id']);
            if(!empty($data['parent_id']))
            {
                $data['parentid'] = $data['parent_id'];
            }
            unset($data['parent_id']);
            $rs = '';
            if(!$cat_id)
            {
                $rs = $category_model->addCategory($data);
            }else{
                $rs = $category_model->updateCategory($data,$cat_id);
            }
            if($rs)
            {
                $this->success(L('ADMIN_SUCCESS'),U('Category/CategoryList'));
                exit;
            }else{
                $this->error($category_model->error);
            }
        }
        $catid = I('get.cat_id','');
        $parent_id = I('get.parent_id','');
        if(!empty($parent_id))
        {
           $this->assign('parentid',$parent_id); 
        }
        $info = $category_model->getCategory($catid);
        $this->assign('data',$info);
        $this->display('Category/CategoryEdit');
    }
    /*update Category is_show*/
    public function ajaxUpdate()
    {
        $cat_id = I('cat_id','');
        $state = I('state','');
        $data['is_show'] = $state == 1 ? 0 : 1;
        $rs =D('Category')->updateCategory($data,$cat_id);
        if(!empty($rs))
        {
            $result['code'] = 1;
        }else{
            $result['code'] = 0;
        }
        $result['state'] = $data['is_show'];
        echo json_encode($result); 
        die; 
    }

    /**
    * @HQtag: delete Category
    */
    public function deleteCategory()
    {
        $cat_id = I('get.cat_id','');
        if(!empty($cat_id))
        {
            /*有子分类不准删除*/
            $subCat = D('Category')->getCategoryData(array('parentid'=>$cat_id));
            if(!empty($subCat))
            {
                $this->error(L('DELE_CAT').L('ADMIN_FAILED'));
                exit;
            }
            $rs = D('Category')->DeleteCategory($cat_id);
            if(!empty($rs))
            {
                $this->success(L('DELE_CAT').L('ADMIN_SUCCESS'),U('Category/CategoryList'));
                exit;
            }
        }
        $this->error(L('DELE_CAT').L('ADMIN_FAILED'));
    }
}