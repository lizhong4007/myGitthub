<?php
namespace Common\Service;
use \Think\Model;
/**
* Brand Service
*/
class BrandService extends Model
{
	/*错误信息*/
	public $error = '';

	/**
	 * 处理brand数据
	 * @param  array $data
	 * @return false | 
	 */
	public function dealBrand($data = array())
	{
		echo 1233;exit;
		if(empty($data))
		{
			return false;
		}
		if(empty($data['brand_name']))
		{
			$this->error = L('ADMIN_BRAND').L('ADMIN_NOTEMPTY');
			return false ;
		}else{
			$brand_name = get_substr($data['brand_name'],50);
			if(!$brand_name)
			{
				$this->error = L('ADMIN_BRAND').L('TOO_LONG');
				return false ;
			}else{
				$data['brand_name'] = $brand_name;
			}
		}
		//英文名
		if(empty($data['brand_alias']))
		{
			$this->error = L('ADMIN_LANGUAGE_NAME').L('ADMIN_NOTEMPTY');
			return false ;
		}else{
			$brand_alias = get_substr($data['brand_alias'],50);
			if(!$brand_alias)
			{
				$this->error = L('ADMIN_LANGUAGE_NAME').L('TOO_LONG');
				return false ;
			}else{
				$data['brand_alias'] = $brand_alias;
			}
		}
		//字母
		$letter = strtoupper(get_substr($brand_alias,1));
		$data['letter'] = $letter;
		$linkurl = preg_replace("/[^0-9a-zA-Z]/", "-", $brand_alias);
		$data['linkurl'] = trim($linkurl);

		if(empty($data['thumb']))
		{
			$this->error = L('IMAGE_SELECT');
			return false ;
		}

		return $data;
	}

}