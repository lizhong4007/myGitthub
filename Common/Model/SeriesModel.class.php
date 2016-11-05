<?php
namespace Common\Model;
use \Think\Model;
/**
 * 系列模型model
 * @package sample
 * @subpackage classes
 */
class SeriesModel extends Model
{
	public $error = '';
	/**
	*功能：获取系列列表
	*@param array $where
	*@param int $p 起始页
	*@param int $size 每页显示条数
	*@param string $order 排序
	*@return false | array数据和分页
	**/
	public function getSeriesList($where = array('1'),$p = 0,$size = 20,$order = 'seriesid DESC')
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
	public function addSeries($data = array())
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
		if(empty($data['series_name']))
		{
			$this->error = L('ADMIN_SERIES').L('ADMIN_NAME').L('ADMIN_NOTEMPTY');
			return false;
		}
        //处理数据
		$data = $this->dealSeriesData($data);
		if(!$data)
		{
			return false;
		}
		//验证系列是否存在
		$info = '';
		$info = $this->checkSeries($data);
		if($info)
		{
			//修改公司ids
			if(!empty($data['companyids']))
			{
				if(!in_array($data['companyids'],explode(',', $info['companyids'])))
				{
					$this->updateSeries(array('companyids'=>$info['companyids'].','.$data['companyids']),$info['seriesid']);
				}
			}
			$this->error = L('ADMIN_SERIES').L('ADMIN_NAME').L('ADMIN_EXISTED');
			return false;
		}
		//系列内容
		$content = '';
		if(!empty($data['content']))
		{
			$content = $data['content'];
		}
		if(isset($data['content']))
		{
			unset($data['content']);
		}
		$data['addtime'] = TIMESTAMP;
        //添加系列
		$seriesid = '';
		$seriesid = $this->add($data);
		if($seriesid)
		{
			if(!empty($content))
			{
				$this->addSeriesContent($content,$seriesid);
			}
			return $seriesid;
		}else{
			$this->error = L('ADMIN_SERIES').L('ADMIN_ADD').L('ADMIN_FAILED');
			return false;
		}
	}
	/**
     * 功能：修改系列
     * @param array $data 系列数据
     * @param int $seriesid 系列id
     * @return false | $seriesid 系列id
     */
	public function updateSeries($data = array(),$seriesid = 0)
	{
		$data = $this->dealSeriesData($data);//处理数据
		$seriesid = intval($seriesid);
		if(empty($data) or $seriesid <= 0) return false;
        //验证系列是否存在
		$info = '';
		$info =  $this->getSeries($seriesid);
		if(!$info)
		{
			$this->error = L('ADMIN_SERIES').L('ADMIN_NOEXISTED');
			return false;
		}
		$data['catid'] = $info['catid'];
		$data['brandid'] = $info['brandid'];
		$series = '';
		$series = $this->checkSeries($data);		
		if($series)
		{
			if($series['seriesid'] != $seriesid)
			{
				$this->error = L('ADMIN_SERIES').L('ADMIN_EXISTED');
				return false;
			}
		}
		//不允许修改数据
		if(isset($data['catid']))  unset($data['catid']);
		if(isset($data['brandid'])) unset($data['brandid']);
		//系列内容
		$content = '';
		if(!empty($data['content']))
		{
			$content = $data['content'];
		}
		if(isset($data['content']))
		{
			unset($data['content']);
		}
		$rs_content = '';
		if(!empty($content))
		{
			$rs_content = $this->addSeriesContent($content,$seriesid);
		}
		//修改
		$rs = '';
		$rs = $this->where(array('seriesid'=>$seriesid))->save($data);
		if($rs)
		{
			return $seriesid;
		}else{
			$message = '';
			if($rs_content)
			{
				$message = L('ADMIN_CONTENT').L('ADMIN_SUCCESS').L('ADMIN_SERIES').L('ADMIN_UPDATE').L('ADMIN_FAILED');
			}else{
				$message = L('ADMIN_SERIES').L('ADMIN_UPDATE').L('ADMIN_FAILED');
			}
			$this->error = $message;
			return false;
		}
	}
	/**
     * 功能：验证系列是否存在
     * @param array $data 
     * @return false | array 
     */
	private function checkSeries($data = array())
	{
		if(empty($data)) return false;
		$where = array();
		$where['catid'] = $data['catid'];
		$where['brandid'] = $data['brandid'];
		$where['series_name'] = $data['series_name'];
		//查询
		$series = '';
		$series = $this->getSeriesData($where);
		if($series)
		{
			return array_pop($series);
		}else{
			return false;
		}
	}
    /**
     * 功能：根据id获取单条系列
     * @param int $seriesid 资源id
     * @return false | array 资源信息
     */
	public function getSeries($seriesid = 0)
	{
		$seriesid = intval($seriesid);
		if($seriesid <= 0) return false;
		return $this->where(array("seriesid"=>$seriesid))->find();
	}

	/**
     * 功能：查询系列数据
     * @param array $where 
     * @param int $limit 是否限制 
     * @return false | array 
     */
	public function getSeriesData($where = array(),$limit = 0)
	{
		if($limit != 0)
		{
			return $this->where($where)->limit(0,$limit)->select();
		}else{
			return $this->where($where)->select();
		}
		
	}
	/**
     * 功能：处理系列数据，检查分类和品牌是否存在
     * @param array $data 
     * @return false | array 
     */
	private function dealSeriesData($data = array())
	{
		if(empty($data)) return false;
		$series_name = '';
		$linkurl_tmp = '';
		if(!empty($data['series_name']))
		{
			$series_name = get_substr($data['series_name'],255);
			if(!$series_name)
			{
				$this->error = L('ADMIN_SERIES').L('TOO_LONG').'255';
				return false;
			}
			$data['series_name'] = $series_name;
			if(empty($data['series_alias']))//如果没有中文
			{
				$linkurl_tmp = trim(preg_replace('/[^0-9a-zA-Z]/',' ', $series_name));
			}
		}
		if(!empty($data['series_alias']))
		{
			$linkurl_tmp = trim($data['series_alias']);
		}
		$data['letter'] = strtoupper(substr($linkurl_tmp,0,1));
		$linkurl = preg_replace('/[\s]+/i','-',$linkurl_tmp);
		$linkurl = strtolower($linkurl);
		$data['linkurl'] = preg_replace("/(-)+/i","-",$linkurl);
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
		//不允许修改数据
		if(isset($data['seriesid'])) unset($data['seriesid']);
		return $data;
	}
	/**
     * 功能：根据seriesid获取多条系列内容
     * @param int $seriesid 资源id
     * @return false | array 资源信息
     */
	public function getSeriesContent($seriesid = '')
	{
		return M('series_content')->where(array("seriesid"=>$seriesid))->find();
	}
	/**
     * 功能：添加或修改系列内容
     * @param string $content 
     * @param int $seriesid 
     * @return bool 
     */
	private function addSeriesContent($content = '',$seriesid = 0)
	{
		$seriesid = intval($seriesid);
		if($seriesid <= 0 or empty($content))
		{
			return false;
		}
		$series_content_table = M('series_content');
		$info = '';
		$info = $series_content_table->where(array('seriesid'=>$seriesid))->find();
		$rs = '';
		if($info)//修改
		{
			$rs = $series_content_table->where(array('scid'=>$info['scid']))->save(array('content'=>$content));
		}else{
			$rs = $series_content_table->add(array('content'=>$content,"seriesid"=>$seriesid));
		}
		return $rs;
	}
	/**
     * 功能：根据系列id获取系列资源（花纹）
     * @param int $seriesid 
     * @return bool | array 
     */
	public function getSeriesResource($seriesid = 0)
	{
		return M('SeriesResource')->where(array('seriesid'=>$seriesid))->select();
	}
	/**
     * 功能：添加系列资源（花纹）
     * @param array $data 
     * @return bool | array 
     */
	public function addSeriesResource($data = array())
	{
		if(empty($data)) return false;
		if(empty($data['local_thumb']))
		{
			$this->error = L('ADMIN_IMAGE').L('ADMIN_NOTEMPTY');
			return false;
		}
		$series = $this->getSeries($data['seriesid']);
		if(!$series)
		{
			$this->error = L('ADMIN_SERIES').L('ADMIN_NOEXISTED');
			return false;
		}
		$M_series_resource = M('SeriesResource');
		$info = $M_series_resource->where($data)->select();
		if($info)
		{
			return false;
		}
		return $M_series_resource->add($data);
	}
}