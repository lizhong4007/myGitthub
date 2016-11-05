<?php
return array(
	//配置模版文件
	'DEFAULT_THEME'=>'default',
	'TMPL_PARSE_STRING'  =>array(
	    '__STATIC__'     => '/Public/Admin/default'
	),
	// 'TMPL_EXCEPTION_FILE' => __PUBLIC__.'/tyre_manage.tpl',//异常模板
	'NAVIGATION'=>array(
		array(//navigation
			'title'=>'ADMIN_GOODS_MANAGE',
			'icon'=>'fa-th-large',
			'controller'=>array(//Controller
				'Goods'=>array(
					'lists'=>'GOODS_LIST',
					'index'=>'goodsList',
					'url'=>'Goods/goodsList',
					'action'=>array(//action
						'index'=>'GOODS_LIST',
						'add'=>'ADD_GOODS',
						'dele'=>'DELE_GOODS'
					)
				),
				'Category'=>array(
					'lists'=>'GOODS_CATEGORY',
					'index'=>'categoryList',
					'url'=>'Category/categoryList',
					'action'=>array(
						'list'=>'CAT_LIST',
						'add'=>'ADD_CAT',
						'delete'=>'DELE_CAT'
					)
				),
				'Brand'=>array(
					'lists'=>'BRANDS_LIST',
					'index'=>'BrandList',
					'url'=>'Brand/brandList',
					'action'=>array(
						'list'=>'BRANDS_LIST',
						'add'=>'ADD_BRANDS',
						'delete'=>'DELE_BRANDS'
					)
				),
				'GoodsDefault'=>array(
					'lists'=>'DEFAULT_PARAM_LIST',
					'index'=>'GoodsDefaultParamList',
					'url'=>'GoodsDefault/GoodsDefaultParamList',
					'action'=>array(
						'list'=>'DEFAULT_PARAM_LIST',
					)
				),
				
			),
						
		),
		array(
			'title'=>'COMPANY_MANAGE',
			'icon'=>'fa-user',
			'controller'=>array(
				'Company'=>array(
					'lists'=>'COMPANY_LIST',
					'index'=>'companyList',
					'url'=>'Company/companyList',
					'action'=>array(
						'list'=>'COMPANY_LIST',
						'add'=>'ADD_COMPANY',
						'delete'=>'DELE_COMPANY'
					)
				),
				'CompanyDistributor'=>array(
					'lists'=>'COMPANY_DISTRIBUTOR_LIST',
					'index'=>'companyDistributorList',
					'url'=>'CompanyDistributor/companyDistributorList',
					'action'=>array(
						'list'=>'COMPANY_DISTRIBUTOR_LIST',
						// 'add'=>'ADD_GROUP',
						// 'delete'=>'DELE_GROUP'
					)
				),
				
			),
						
		),
		array(
			'title'=>'MODEL_MANAGE',
			'icon'=>'fa-dashboard',
			'controller'=>array(
				'Model'=>array(
					'lists'=>'MODEL_LIST',
					'index'=>'modelList',
					'url'=>'Model/modelList',
					'action'=>array(
						'list'=>'MODEL_LIST',
					)
				),
				'Series'=>array(
					'lists'=>'SERIES_LIST',
					'index'=>'seriesList',
					'url'=>'Series/seriesList',
					'action'=>array(
						'list'=>'SERIES_LIST',
						// 'add'=>'ADD_GROUP',
						// 'delete'=>'DELE_GROUP'
					)
				),
				'ModelCars'=>array(
					'lists'=>'MODEL_CARS_LIST',
					'index'=>'modelCarsList',
					'url'=>'ModelCars/modelCarsList',
					'action'=>array(
						'list'=>'MODEL_CARS_LIST',
					)
				),
				'Cars'=>array(
					'lists'=>'CARS_LIST',
					'index'=>'carsList',
					'url'=>'Cars/carsList',
					'action'=>array(
						'list'=>'CARS_LIST',
					)
				),
				
			),
						
		),
		array(
			'title'=>'ADMIN_PERMISSION_MANAGE',
			'icon'=>'fa-key',
			'controller'=>array(
				'Users'=>array(
					'lists'=>'USERS_LIST',
					'index'=>'usersList',
					'url'=>'Users/usersList',
					'action'=>array(
						'list'=>'USERS_LIST',
						'add'=>'ADD_USERS',
						'delete'=>'DELE_USERS'
					)
				),
				'Groups'=>array(
					'lists'=>'GROUP_LIST',
					'index'=>'groupList',
					'url'=>'Groups/groupList',
					'action'=>array(
						'list'=>'GROUP_LIST',
						'add'=>'ADD_GROUP',
						'delete'=>'DELE_GROUP'
					)
				),
				
			),
						
		),//
		array(
			'title'=>'SET_MANAGE',
			'icon'=>'fa-gears',
			'controller'=>array(
				'Navigation'=>array(
					'lists'=>'NAVIGATION_LIST',
					'index'=>'navigationList',
					'url'=>'Navigation/navigationList',
					'action'=>array(
						'list'=>'NAVIGATION_LIST',
						'add'=>'EDIT_NAVIGATION',
						'delete'=>'DELETE_NAVIGATION'
					)
				),
				
				
			),
						
		),//
		
    ),
    /*===============公司经营模式==========================*/
    'MANAGEMENT_MODEL'=>array(
    	'Manufacturer',
    	'Trading_Company', 
    	'Distributor',
    	'Repairer',
    	'Online_Retailer',
    	),
 );