<?php
return array(
	//'配置项'=>'配置值'
	//配置模版文件
	'DEFAULT_THEME'=>'default',
	'TMPL_PARSE_STRING'  =>array(
	    '__STATIC__'     => '/Public/home/default'
	),
	'URL_CASE_INSENSITIVE'=>true,
	'URL_ROUTER_ON'   => true, //开启路由
	'URL_ROUTE_RULES' => array( //定义路由规则
	    /*'nav/ince' => 'Index/nine',
	    'nav/:tag' => 'Index/Index',
	    'cid/:cid'=>'Index/Index',
	    'detail/:iid'=>'Index/detail',
	    'Jump/:iid'=>'Jump/Index',*/
	    'p/:p'=>'HomePage/Index',
	    'Search/p/:p'=>'Search/search',
	    /*'Worth/p/:p'=>'Worth/Index',
	    '/^worth\/detail\/id.(\d*)$/'=>'Worth/detail?wid=:1'*/
	),
);