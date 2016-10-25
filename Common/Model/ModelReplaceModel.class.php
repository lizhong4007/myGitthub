<?php
namespace Common\Model;
use \Think\Model;
/**
 * 型号可替换模型model
 * @package sample
 * @subpackage classes
 */
class ModelReplaceModel extends Model
{
	public $error = '';
	/**
	*功能：根据型号id获取可替换型号
	*@return false | array
	**/
	public function getModelbyModelid($modelid = 0)
	{
		$modelid = intval($modelid);
		return $this->where(array("modelid"=>$modelid))->select();
	}
}