<?php
namespace Common\Model;
use \Think\Model;
/**
 * 分类模型model
 * @package sample
 * @subpackage classes
 */
class CategoryModel extends Model
{
	public $error = '';
	/**
	 * 功能：获取分类列表
	 * 存入缓存
	 * @return array 分类信息
	 */
	public function getCategoryList()
	{
		$catlist = S('Categorylist');
		if(empty($catlist)){
			$catlist = array();
			$catlist = $this->catSort();
			S('Categorylist',$catlist);
		}
		return $catlist;
	}
    /**
     * 功能：递归查询分类信息
     * @param  integer $pid   [父级分类]
     * @param  array   $cat   [返回分类信息]
     * @param  integer $level [层级]
     * @return array   查询到的分类信息
     */
	private function catSort($pid = 0,$cat = array(),$level = 0)
	{
		$data = $this->where('parentid='.$pid)->select();
		foreach ($data as $key => $value) {
		  $value['level'] = $level;
          $cat[$value['catid']] = $value;
          $cat = $this->catSort($value['catid'],$cat,$level+1);
		}
		return $cat;
	}
	/**
	 * 功能：添加分类,删除分类缓存
	 * @param array $data 分类信息
	 */
	public function addCategory($data=array())
	{
		//非空数据
		if(empty($data['cat_name']) or empty($data['cat_alias']))
		{
			$this->error = L('ADMIN_CAT').L('ADMIN_NOTEMPTY');
			return false;
		}
		if(empty($data['parentid']))
		{
			$data['parentid'] = 0;
		}
		$data = $this->dealCategory($data);
		if(empty($data)) return false;
		//检查分类
		$info = '';
		$info = $this->checkCategory($data);//同级分类下不可以重名
		if($info)
		{
			$this->error = L('ADMIN_CAT').L('ADMIN_EXISTED');
			return false;
		}
		//添加
		$catid = '';
		$catid = $this->filter('strip_tags')->add($data);
		S('Categorylist',NULL);
		if($catid)
		{
			return $catid;
		}else{
			$this->error = L('ADMIN_UPDATE').L('ADMIN_EXISTED');
			return false;
		}
	}
	/**
	 * 功能：修改分类,删除分类缓存
	 * @param array $data 分类信息
	 * @param int $catid 分类id
	 */
	public function updateCategory($data=array(),$catid = 0)
	{
		$catid = intval($catid);
		if(empty($data) or $catid <= 0) return false;
		$data = $this->dealCategory($data);
		//验证分类是否存在
		$category = '';
		$category = $this->getCategory($catid);
		if(!$category)
		{
			$this->error = L('ADMIN_CAT').L('ADMIN_NOEXISTED');
			return false;
		}
		if(empty($data['parentid']))
		{
			$data['parentid'] = $category['parentid'];
		}
		//检查分类
		$info = '';
		$info = $this->checkCategory($data);
		if($info)
		{
			if($catid != $info['catid'])
			{
				$this->error = L('ADMIN_CAT').L('ADMIN_EXISTED');
				return false;
			}
		}
		//修改
		$rs = '';
	    $rs = $this->where(array('catid'=>$catid))->save($data);
	    if($rs)
	    {
	    	S('Categorylist',NULL);
			return $catid;
	    }else{
	    	$this->error = L('ADMIN_UPDATE').L('ADMIN_FAILED');
	    	return false;
	    }
	}
    /**
     * 功能：根据id获取分类信息
     * @param  int $catid 分类id
     * @return bool | 分类信息
     */
	public function getCategory($catid = 0)
	{
		$catid = intval($catid);
		if($catid <= 0) return false;
		return $this->where(array('catid'=>$catid))->find();
	}
	/**
	 * 功能：根据条件查询多条分类信息
	 * @param  array $where 查询条件
	 * @return 分类信息
	 */
	public function getCategoryData($where = array())
	{
		return $this->where($where)->select();
	}
	/**
	 * 功能：检查分类是否存在
	 * @param  array $data 查询条件
	 * @return 分类信息
	 */
	public function checkCategory($data = array())
	{
		if(empty($data)) return false;
		$where = array();
		$where['cat_name'] = $data['cat_name'];
		$where['cat_alias'] = $data['cat_alias'];
		$where['_logic'] = 'or';
		$final_where = array();
		$final_where['_complex'] = $where;
		$final_where['parentid'] = $data['parentid'];
		$category = '';
		$category = $this->getCategoryData($final_where);
		if($category)
		{
			return array_pop($category);
		}else{
			return false;
		}
	}
	/**
	 * 功能：处理分类数据
	 * @param  array $data 分类数据
	 * @return bool | $data
	 */
	private function dealCategory($data = array())
	{
		if(empty($data)) return false;
		if(!empty($data['cat_name']))
		{
			$cat_name = '';
			$cat_name = get_substr($data['cat_name'],50);
			if(!$cat_name)
			{
				$this->error = L('ADMIN_CAT').L('TOO_LONG').'50';
				return false;
			}
			$data['cat_name'] = $cat_name;
		}
		if(!empty($data['cat_alias']))
		{
			$cat_alias = '';
			$cat_alias = get_substr($data['cat_alias'],50);
			$data['cat_alias'] = strtolower($cat_alias);
			$data['letter'] = strtoupper(substr($cat_alias,0,1));
		}
		if(isset($data['catid']))
		{
			unset($data['catid']);
		}
		return $data;
	}
	/**
	 * 功能：删除分类信息,分类下有商品不准删除
	 * @param  int $catid [分类id]
	 * @return bool
	 */
	public function deleteCategory($catid = 0)
	{
		$catid = intval($catid);
		if($catid <= 0) return false;
		//商品表是否有该分类数据
	    $goods = '';
	    $goods = D('Goods')->getGoodsData(array("catid"=>$catid));
	    if($goods)
	    {
	    	$this->error = L('ADMIN_NOT').L('ADMIN_DELETE').L('ADMIN_PERMISSION');
	    	return false;
	    }
		S('Categorylist',NULL);
		return $this->where('catid='.$catid)->delete();
	}
	/**
	 * 功能：根据父级id获取每一级的分类
	 * @return bool | array
	 */
	public function getCategoryByParentid($parentid = 0)
	{
		$parentid = intval($parentid);
		return $this->where(array('parentid'=>$parentid))->select();
	}
}