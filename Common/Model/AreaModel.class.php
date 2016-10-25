<?php
namespace Common\Model;
use \Think\Model;
/**
 * area model
 * @package sample
 * @subpackage classes
 */
class AreaModel extends Model
{
	static $area_table = "area";
	static $city_table = "city";
	static $province_table = "province";
	/**
	 * 根据id查询地区
	 * @param  integer $id 地区id
	 * @return false | array 地区信息
	 */
	public function getArea($id = 0)
	{
		$id = intval($id);
		if($id <= 0) return false;
		return M(self::$area_table)->where(array('id'=>$id))->find();
	}
	/**
	 * 根据id查询城市
	 * @param  integer $idid 城市id
	 * @return false | array 城市信息
	 */
	public function getCity($id = 0)
	{
		$id = intval($id);
		if($id <= 0) return false;
		return M(self::$city_table)->where(array('id'=>$id))->find();
	}
	/**
	 * 根据id查询省份
	 * @param  integer $id 省份id
	 * @return false | array 省份信息
	 */
	public function getProvince($id = 0)
	{
		$id = intval($id);
		if($id <= 0) return false;
		return M(self::$province_table)->where(array('id'=>$id))->find();
	}
	/**
	 * 查询所有省份
	 * @param  integer $id 省份id
	 * @return false | array 省份信息
	 */
	public function getAllProvince($order = "id")
	{
		return  M(self::$province_table)->order($order)->select();
	}
	/**
	 * 根据parentid查询城市
	 * @param  integer $parentid 省份id
	 * @return false | array 城市信息
	 */
	public function getCityByParentid($parentid = 0)
	{
		$parentid = intval($parentid);
		if($parentid <= 0) return false;
		return M(self::$city_table)->where(array('parentid'=>$parentid))->select();
	}
	/**
	 * 根据parentid查询地区
	 * @param  integer $parentid 市id
	 * @return false | array 城市信息
	 */
	public function getAreaByParentid($parentid = 0)
	{
		$parentid = intval($parentid);
		if($parentid <= 0) return false;
		return M(self::$area_table)->where(array('parentid'=>$parentid))->select();
	}

}