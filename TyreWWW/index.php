<?php
 //    if( !file_exists(dirname(__FILE__) . "/Install/lock.php") )
	// {
	// 	header("Location:Install/index.php");
	// 	exit();
	// }
	// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为 false,true
	define('APP_DEBUG',false);
	// 定义应用目录
	define('APP_PATH','./');
	header("Content-type:text/html;charset=utf-8");
	define('TIMESTAMP', time());
	// 引入ThinkPHP入口文件
	require './ThinkPHP/ThinkPHP.php';

?>