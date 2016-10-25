<?php
namespace Common\Model;
use \Think\Model;
/**
 * 商品模型model
 * @package sample
 * @subpackage classes
 */
class GoodsModel extends Model
{
	public $error = '';
	/**
	*功能：获商品列表
	*@param array $where
	*@param int $p 起始页
	*@param int $size 每页显示条数
	*@param string $order 排序
	*@return false | array数据和分页
	**/
	public function getGoodsList($where = array('1'),$p = 0,$size = 20,$order = 'goodsid DESC')
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
	*功能：添加产品
	*@param array $data
	*@return false | array 
	**/
	public function addGoods($data = array())
	{
		if(empty($data)) return false;
		// 非空数据
		if(empty($data['catid']))//分类
		{
			$this->error = L('ADMIN_CAT').L('ADMIN_NOTEMPTY');
			return false;
		}
		if(empty($data['brandid']))//品牌
		{
			$this->error = L('ADMIN_BRAND').L('ADMIN_NOTEMPTY');
			return false;
		}
		if(empty($data['seriesid']))//系列
		{
			$this->error = L('ADMIN_SERIES').L('ADMIN_NOTEMPTY');
			return false;
		}
		if(empty($data['title']))//名称
		{
			$this->error = L('ADMIN_GOODS').L('ADMIN_NAME').L('ADMIN_NOTEMPTY');
			return false;
		}
		if(empty($data['modelid']))//型号
		{
			$this->error = L('ADMIN_MODEL').L('ADMIN_NAME').L('ADMIN_NOTEMPTY');
			return false;
		}
		$data['addtime'] = TIMESTAMP;
		//处理数据
		$data = $this->dealGoodsData($data);
		if(!$data)
		{
			return false;
		}
		//检查商品是否存在
		$info = '';
		$info = $this->checkGoods($data);
		if($info)
		{
			$this->error = L('ADMIN_GOODS').L('ADMIN_NAME').L('ADMIN_EXISTED');
			return false;
		}
		$content = '';
		if(!empty($data['content']))
		{
			$content = $data['content'];
		}
		if(isset($data['content']))
		{
			unset($data['content']);
		}
		//添加产品
		$goodsid = '';
		$goodsid = $this->add($data);
		if($goodsid)
		{
			if(!empty($content))
			{
				D('GoodsContent')->addGoodsContent($content,$goodsid);
			}
			return $goodsid;
		}else{
			$this->error = L('ADMIN_GOODS').L('ADMIN_ADD').L('ADMIN_FAILED');
			return false;
		}
	}
	/**
     * 功能：修改产品
     * @param array $data 产品数据
     * @param int $goodsid 产品id
     * @return false | $goodsid 产品id
     */
	public function updateGoods($data = array(),$goodsid = 0)
	{
		$data = $this->dealGoodsData($data);//处理数据
		$goodsid = intval($goodsid);
		if(empty($data) or $goodsid <= 0) return false;
        //验证产品是否存在
		$info = '';
		$info =  $this->getGoods($goodsid);
		if(!$info)
		{
			$this->error = L('ADMIN_GOODS').L('ADMIN_NOEXISTED');
			return false;
		}
		//检查产品唯一性
		$goods = '';
		$goods = $this->checkGoods($data);
		if($goods)
		{
			if($goods['goodsid'] != $goodsid)
			{
				$this->error = L('ADMIN_GOODS').L('ADMIN_NAME').L('ADMIN_EXISTED');
				return false;
			}
		}
		//商品内容
		if(!empty($data['content']))
		{
			D('GoodsContent')->addGoodsContent($data['content'],$goodsid);
		}
		if(isset($data['content']))
		{
			unset($data['content']);
		}
		//修改
		$rs = '';
		$rs = $this->where(array('goodsid'=>$goodsid))->save($data);
		if($rs)
		{
			return $goodsid;
		}else{
			$this->error = L('ADMIN_GOODS').L('ADMIN_UPDATE').L('ADMIN_FAILED');
			return false;
		}
	}
	/**
     * 功能：检查同一个公司，相同品牌、分类、系列下是否存在同一产品
     * @param array $data 
     * @return false | array 
     */
	private function checkGoods($data = array())
	{
		if(empty($data)) return false;
		$where = array();
		$where['catid'] = $data['catid'];
		$where['brandid'] = $data['brandid'];
		$where['seriesid'] = $data['seriesid'];
		$where['modelid'] = $data['modelid'];
		$where['title'] = $data['title'];
		$where['companyid'] = empty($data['companyid']) ? 0 : $data['companyid'];
		$goods = '';
		$goods = $this->getGoodsData($where);
		if($goods)
		{
			return array_pop($goods);
		}else{
			return false;
		}
	}
	/**
     * 功能：处理产品数据,检查分类，品牌，系列是否存在
     * @param array $data 
     * @return false | array 
     */
	private function dealGoodsData($data = array())
	{
		if(empty($data)) return false;
		$title = '';
		if(!empty($data['title']))//名称
		{
			$title = get_substr($data['title'],255);
			if(!$title)
			{
				$this->error = L('ADMIN_MODEL').L('TOO_LONG').'255';
				return false;
			}
			$data['title'] = $title;
		}
		if(!empty($data['modelid']))//型号
		{
			$findmodel = '';
			$findmodel = D('Model')->getModel($data['modelid']);
			if(!$findmodel)
			{
				$this->error = L('ADMIN_MODEL').L('ADMIN_NOEXISTED');
				return false;
			}
		}
		if(!empty($data['catid']))//分类
		{
			$findcat = '';
			$findcat = D('Category')->getCategory($data['catid']);
			if(!$findcat)
			{
				$this->error = L('ADMIN_CAT').L('ADMIN_NOEXISTED');
				return false;
			}
		}
		if(!empty($data['brandid']))//品牌
		{
			$findbrand = '';
			$findbrand = D('Brand')->getBrand($data['brandid']);
			if(!$findbrand)
			{
				$this->error = L('ADMIN_BRAND').L('ADMIN_NOEXISTED');
				return false;
			}
		}
		if(!empty($data['seriesid']))//系列
		{
			$findseries = '';
			$findseries = D('Series')->getSeries($data['seriesid']);
			if(!$findseries)
			{
				$this->error = L('ADMIN_SERIES').L('ADMIN_NOEXISTED');
				return false;
			}
		}
		if(!empty($data['companyid']))//公司
		{
			$findcompany = '';
			$findcompany = D('Company')->getCompany($data['companyid']);
			if(!$findcompany)
			{
				$this->error = L('COMPANY').L('ADMIN_NOEXISTED');
				return false;
			}
		}
		if(empty($data['min_price']))
		{
			$data['min_price'] = 0;
		}else{
			$data['min_price'] = preg_replace("/[^0-9\.]+/","",$data['min_price']);
	        $data['min_price'] = floatval($data['min_price']);
		}
		if(empty($data['max_price']))
		{
			$data['max_price'] = 0;
		}else{
			$data['max_price'] = preg_replace("/[^0-9\.]+/","",$data['max_price']);
	        $data['max_price'] = floatval($data['max_price']);
		}
		if(!empty($data['en_title']))
		{
			$data['en_title'] = trim($data['en_title']);
			$linkurl = preg_replace('/[^0-9a-zA-Z]/', '-', $data['en_title']);
			$linkurl = preg_replace("/(-)+/i","-",$linkurl);
			$data['linkurl'] = $linkurl;
		}
		//不允许修改数据
		if(isset($data['goodsid'])) unset($data['goodsid']);

		return $data;
	}
	/**
	*功能：根据id查询单条产品信息
	*@param int $goodsid
	*@return false | array 
	**/
	public function getGoods($goodsid = 0)
	{
		$goodsid = intval($goodsid);
		if($goodsid <= 0) return false;
		return $this->where(array("goodsid"=>$goodsid))->find();
	}
	/**
	*功能：查询多条产品信息
	*@param array $where
	*@return false | array 
	**/
	public function getGoodsData($where = array())
	{
		if(empty($where)) return false;
		return $this->where($where)->select();
	}

}