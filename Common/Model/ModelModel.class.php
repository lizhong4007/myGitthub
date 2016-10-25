<?php
namespace Common\Model;
use \Think\Model;
/**
 * 型号模型model
 * @package sample
 * @subpackage classes
 */
class ModelModel extends Model
{
	public $error = '';
	/**
	*功能：获取型号列表
	*@param array $where
	*@param int $p 起始页
	*@param int $size 每页显示条数
	*@param string $order 排序
	*@return false | array数据和分页
	**/
	public function getModelList($where = array('1'),$p = 0,$size = 20,$order = 'modelid DESC')
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
     * 功能：添加系列
     * @param array $data 添加数据
     * @return false | $resid 资源id
     */
	public function addModel($data = array())
	{
		if(empty($data)) return false;
		//非空数据
		if(empty($data['catid']))
		{
			$this->error = L('ADMIN_CAT').L('ADMIN_NOTEMPTY');
			return false;
		}
		if(empty($data['brandid']))
		{
			$this->error = L('ADMIN_BRAND').L('ADMIN_NOTEMPTY');
			return false;
		}
		if(empty($data['seriesid']))
		{
			$this->error = L('ADMIN_SERIES').L('ADMIN_NOTEMPTY');
			return false;
		}
		if(empty($data['model_name']))
		{
			$this->error = L('ADMIN_MODEL').L('ADMIN_NAME').L('ADMIN_NOTEMPTY');
			return false;
		}
        //检查数据
		$data = $this->dealModelData($data);
		if(!$data)
		{
			return false;
		}
		//验证型号是否存在
		$info = '';
		$info = $this->checkModel($data);
		if($info)
		{
			$this->error = L('ADMIN_MODEL').L('ADMIN_NAME').L('ADMIN_EXISTED');
			return $info['modelid'];
		}
		$data['addtime'] = TIMESTAMP;
        //添加型号
		$modelid = '';
		$modelid = $this->add($data);
		if($modelid)
		{
			return $modelid;
		}else{
			$this->error = L('ADMIN_MODEL').L('ADMIN_ADD').L('ADMIN_FAILED');
			return false;
		}
	}
	/**
     * 功能：修改型号
     * @param array $data 型号数据
     * @param int $modelid 型号id
     * @return false | $modelid 型号id
     */
	public function updateModel($data = array(),$modelid = 0)
	{
		$data = $this->dealModelData($data);//处理数据
		$modelid = intval($modelid);
		if(empty($data) or $modelid <= 0) return false;
        //验证型号是否存在
		$info = '';
		$info =  $this->getModel($modelid);
		if(!$info)
		{
			$this->error = L('ADMIN_MODEL').L('ADMIN_NOEXISTED');
			return false;
		}
		//检查型号唯一性
		$model = '';
		$model = $this->checkModel($data);
		if($model)
		{
			if($model['modelid'] != $modelid)
			{
				$this->error = L('ADMIN_MODEL').L('ADMIN_NAME').L('ADMIN_EXISTED');
				return false;
			}
		}
		//不允许修改数据
		if(isset($data['catid']))  unset($data['catid']);
		if(isset($data['brandid'])) unset($data['brandid']);
		if(isset($data['seriesid'])) unset($data['seriesid']);
		//修改
		$rs = '';
		$rs = $this->where(array('modelid'=>$modelid))->save($data);
		if($rs)
		{
			return $modelid;
		}else{
			$this->error = L('ADMIN_MODEL').L('ADMIN_UPDATE').L('ADMIN_FAILED');
			return false;
		}
	}
	/**
     * 功能：验证型号是否存在(唯一性)
     * @param array $data 
     * @return false | array 型号信息
     */
	private function checkModel($data = array())
	{
		if(empty($data)) return false;
		$where = array();
		$where['catid'] = $data['catid'];
		$where['brandid'] = $data['brandid'];
		$where['seriesid'] = $data['seriesid'];
		$where['model_name'] = $data['model_name'];
		$model = '';
		$model = $this->getModelData($where);
		if($model)
		{
			return array_pop($model);
		}else{
			return false;
		}
	}
    /**
     * 功能：根据id获取单条型号
     * @param int $modelid 型号id
     * @return false | array 型号信息
     */
	public function getModel($modelid = 0)
	{
		$modelid = intval($modelid);
		if($modelid <= 0) return false;
		return $this->where(array("modelid"=>$modelid))->find();
	}
	/**
     * 功能：查询多条型号数据
     * @param array $where 
     * @return false | array 
     */
	public function getModelData($where = array())
	{
		return $this->where($where)->select();
	}
	/**
     * 功能：处理型号数据,检查分类，品牌，系列是否存在
     * @param array $data 
     * @return false | array 
     */
	private function dealModelData($data = array())
	{
		if(empty($data)) return false;
		$model_name = '';
		if(!empty($data['model_name']))
		{
			$model_name = get_substr($data['model_name'],50);
			if(!$model_name)
			{
				$this->error = L('ADMIN_MODEL').L('TOO_LONG').'50';
				return false;
			}
			$data['model_name'] = strtoupper($model_name);
			$linkurl = preg_replace('/[^0-9a-zA-Z]/', '-', $model_name);
			$linkurl = preg_replace("/(-)+/i","-",$linkurl);
			$linkurl = strtolower($linkurl);
			$data['linkurl'] = $linkurl;
		}
		if(!empty($data['catid']))
		{
			$findcat = '';
			$findcat = D('Category')->getCategory($data['catid']);
			if(!$findcat)
			{
				$this->error = L('ADMIN_CAT').L('ADMIN_NOEXISTED');
				return false;
			}
		}
		if(!empty($data['brandid']))
		{
			$findbrand = '';
			$findbrand = D('Brand')->getBrand($data['brandid']);
			if(!$findbrand)
			{
				$this->error = L('ADMIN_BRAND').L('ADMIN_NOEXISTED');
				return false;
			}
		}
		if(!empty($data['seriesid']))
		{
			$findseries = '';
			$findseries = D('Series')->getSeries($data['seriesid']);
			if(!$findseries)
			{
				$this->error = L('ADMIN_SERIES').L('ADMIN_NOEXISTED');
				return false;
			}
		}
		if(!empty($data['resids']))
		{
			$data['resids'] = str_comma($data['resids']);
		}
		//不允许修改数据
		if(isset($data['modelid'])) unset($data['modelid']);

		return $data;
	}
}