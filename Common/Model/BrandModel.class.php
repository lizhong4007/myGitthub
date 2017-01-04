<?php
namespace Common\Model;
use \Think\Model;
/**
 * 品牌模型model
 * @package sample
 * @subpackage classes
 */
class BrandModel extends Model
{
	public $error = '';
	/**
	*功能：获取品牌列表
	*@param array $where
	*@param int $p 起始页
	*@param int $size 每页显示条数
	*@param string $order 排序
	*@return false | array数据和分页
	**/
	public function getBrandList($where = array('1'),$p = 0,$size = 20,$order = 'brandid DESC')
	{
		$data = array();
		$count = $this->where($where)->count();
        $pages = pages($count,$p,$size);
        $result = $this->where($where)->page($p,$size)->order($order)->select();
        $data['data'] = $result;
        $data['page'] = $pages;
		return $data;
	}
	/**
	*功能：添加品牌
	*@param array $data
	*@return false | brandid
	**/
	public function addBrand($data = array())
	{
		if(empty($data)) return false;
        //非空数据
		if(empty($data['brand_name']))
		{
			$this->error = L('ADMIN_BRAND').L('ADMIN_NOTEMPTY');
			return false ;
		}
		if(empty($data['brand_alias']))
		{
			$this->error = L('ADMIN_BRAND').L('ADMIN_LANGUAGE_NAME').L('ADMIN_NOTEMPTY');
			return false ;
		}
		$data = $this->dealBrand($data);
		if(!$data)
		{
			return false;
		}
		// 验证品牌名是否存在
		$brand = '';
		$brand = $this->checkBrand($data);
		if($brand)
		{
			$this->error = L('ADMIN_BRAND').L('ADMIN_EXISTED');
			return false;
		}
		$data['addtime'] = TIMESTAMP;
		$brandid = '';
		$brandid = $this->add($data);
		if($brandid)
		{
			return $brandid;
		}else{
			$this->error = L('ADMIN_BRAND').L('ADMIN_ADD').L('ADMIN_FAILED');
			return false;
		}
	}
	/**
	*功能：修改品牌
	*@param array $data
	*@param int $brandid 品牌id
	*@return false | brandid
	**/
	public function updateBrand($data = array(),$brandid = 0)
	{
		$data = $this->dealBrand($data);
		$brandid = intval($brandid);
		if(empty($data) or $brandid <= 0) return false;
		//验证品牌是否存在
		$findbrand = '';
		$findbrand = $this->getBrand($brandid);
		if(!$findbrand)
		{
			$this->error = L('ADMIN_BRAND').L('ADMIN_NOEXISTED');
			return false;
		}
		//检查是否存在同名
		$brand = '';
		$brand = $this->checkBrand($data);
		if($brand)
		{
			if(count($brand) > 1 or $brand[0]['brandid'] != $brandid)
			{
				$this->error = L('ADMIN_BRAND').L('ADMIN_EXISTED');
				return false;
			}
		}
		//修改
		$result = $this->where('brandid='.$brandid)->save($data);
		if(!empty($result))
		{
			return $brandid;
		}else{
			$this->error = L('ADMIN_BRAND').L('ADMIN_UPDATE').L('ADMIN_FAILED');
			return false;
		}
	}
	/**
	*功能：验证品牌是否存在
	*@param array $data
	*@return false | array 品牌信息
	**/
	private function checkBrand($data = array())
	{
		if(empty($data)) return false;
		//组合条件
		$where = array();
		$where['brand_name']  = $data['brand_name'];
		$where['brand_alias'] = $data['brand_alias'];
		$where['_logic'] = 'or';
		$brand = '';
		$brand = $this->getBrandData($where);
		if($brand)
		{
			return $brand;
		}else{
			return false;
		}
	}
	/**
	*功能：根据brandid获取品牌数据
	*@param int $brandid
	*@return false | array 品牌信息
	**/
	public function getBrand($brandid = 0)
	{
		$brandid = intval($brandid);
		if($brandid <= 0) return false;
		return $this->where(array('brandid'=>$brandid))->find();
	}
	/**
	*功能：获取多条品牌数据
	*@param array $where
	*@return false | array 品牌信息
	**/
	public function getBrandData($where = array(),$limit)
	{
		if(empty($limit))
		{
			return $this->where($where)->select();
		}else{
			return $this->where($where)->limit(0,$limit)->select();
		}
		
	}
	/**
	*功能：根据brandid删除品牌
	*@param int $brandid
	*@return false | array 品牌信息
	**/
	public function deleteBrand($brandid = 0)
	{
		$brandid = intval($brandid);
		if($brandid <= 0) return false;
		//查询产品数据
		$goods = array();
		$goods = D('Goods')->getGoodsData(array('brandid'=>$brandid));
		if($goods)
		{
			return false;
		}
		return $this->where('brandid='.$brandid)->delete();
	}
    /**
	 *功能：获取所有品牌数据，按字母排序
	 *@param string $order
	 *@return  array array('arr_letter'=>$arr_letter,'letter_brands'=>$letter_brands);
	*/
	public function getAllBrand($order = 'brand_alias ASC')
	{
		$brandData = array();
		$brandData =  $this->order($order)->select();
		$brand  = array();
		$letter = array();
		foreach($brandData as $value){
			if($value['letter']){
				$value['letter'] = strtoupper($value['letter']);
				$letter[$value['letter']] = $value['letter'];
				$brand[$value['letter']][] = $value;
			}
			
		}
		ksort($letter);
		ksort($brand);
		return array('letter'=>$letter,'brand'=>$brand);
	}
	/**
	 * 处理brand数据
	 * @param  array $data
	 * @return false | 
	 */
	private function dealBrand($data = array())
	{
		if(empty($data)) return false;
		//数据处理
		if(!empty($data['brand_name']))
		{
			$brand_name = get_substr($data['brand_name'],100);
			if(!$brand_name)
			{
				$this->error = L('ADMIN_BRAND').L('TOO_LONG').'100';
				return false ;
			}else{
				$data['brand_name'] = $brand_name;
			}
		}
		//英文名
		if(!empty($data['brand_alias']))
		{
			$brand_alias = get_substr($data['brand_alias'],50);
			if(!$brand_alias)
			{
				$this->error = L('ADMIN_LANGUAGE_NAME').L('TOO_LONG').'50';
				return false ;
			}else{
				$data['brand_alias'] = $brand_alias;
			}
			//字母
			$letter = strtoupper(get_substr($brand_alias,1));
			$data['letter'] = $letter;
			$linkurl = preg_replace("/[^0-9a-zA-Z]/", "-", $brand_alias);
			$linkurl = preg_replace("/(-)+/i","-",$linkurl);
			$data['linkurl'] = trim($linkurl);
		}
		if(isset($data['brandid']))
		{
			unset($data['brandid']);
		}
		return $data;
	}
}