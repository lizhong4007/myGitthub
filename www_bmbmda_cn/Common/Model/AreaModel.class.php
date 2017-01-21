<?php
namespace Common\Model;
use \Think\Model;
/**
 * city model
 * @package sample
 * @subpackage classes
 */
class AreaModel extends Model
{
	static $city_table = "city";
	static $state_table = "state";
	static $country_table = "country";
	/**
	 * 根据id查询地区
	 * @param  integer $id 地区id
	 * @return false | array 地区信息
	 */
	public function getCity($id = 0)
	{
		$id = intval($id);
		if($id <= 0) return false;
		return M(self::$city_table)->where(array('id'=>$id))->find();
	}
	/**
	 * 根据id查询城市
	 * @param  integer $idid 城市id
	 * @return false | array 城市信息
	 */
	public function getState($id = 0)
	{
		$id = intval($id);
		if($id <= 0) return false;
		return M(self::$state_table)->where(array('id'=>$id))->find();
	}
	/**
	 * 根据id查询省份
	 * @param  integer $id 省份id
	 * @return false | array 省份信息
	 */
	public function getCountry($id = 0)
	{
		$id = intval($id);
		if($id <= 0) return false;
		return M(self::$country_table)->where(array('id'=>$id))->find();
	}
	/**
	 * 查询所有省份
	 * @param  integer $id 省份id
	 * @return false | array 省份信息
	 */
	public function getAllCountry($order = "id")
	{
		return  M(self::$country_table)->order($order)->select();
	}
	/**
	 * 根据parentid查询城市
	 * @param  integer $countryid id
	 * @return false | array 城市信息
	 */
	public function getStateByParentid($countryid = 0)
	{
		$countryid = intval($countryid);
		if($countryid <= 0) return false;
		return M(self::$state_table)->where(array('countryid'=>$countryid))->select();
	}
	/**
	 * 根据stateid查询地区
	 * @param  integer $stateid 市id
	 * @return false | array 城市信息
	 */
	public function getCityByParentid($stateid = 0)
	{
		$stateid = intval($stateid);
		if($stateid <= 0) return false;
		return M(self::$city_table)->where(array('stateid'=>$stateid))->select();
	}

}