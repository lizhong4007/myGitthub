<?php
return array(
	'DB_TYPE'    =>   'mysql',
        'DB_HOST'    =>   '127.0.0.1',
        'DB_USER'    =>   'root',
        'DB_PWD'     =>   'root123',
        'DB_PORT'    =>    3306,
        // 'DB_NAME'    =>   'my_database',
        'DB_NAME'    =>   'my_text',
        'DB_CHARSET' =>   'utf8',
        'DB_PREFIX'  =>   'tyre_',
	'TMPL_TEMPLATE_SUFFIX'=>'.tpl',
	//开启语言包
	'app_begin' => array('CheckLang'),
	'LANG_SWITCH_ON' => true,
    'LANG_AUTO_DETECT' => false, 
    'DEFAULT_LANG' => 'zh-cn', // 默认语言
    // 'DEFAULT_LANG' => 'en-us', // 默认语言
    'LANG_LIST'        => 'zh-cn,en-us', 
    'VAR_LANGUAGE'     => 'l', 
    'LANGUAGES'=>'en',

    'APP_SUB_DOMAIN_DEPLOY'=>1,
    'APP_SUB_DOMAIN_RULES'=>array(
        'manage.tyre.com'=>'tyreManage',
        'image.tyre.com'=>'tyreImage',
        'www.tyre.com'=>'Home',
       
    ),
    'MODULE_SITE'=>array(
        'tyreManage'=>'manage.tyre.com',
        'tyreImage'=>'image.tyre.com',
        'Home'=>'www.tyre.com',
    ),
    //上传文件
    'UPLOAD_FILE_URL'=>'http://image.tyre.com',
    //跳转页面
    // 'TMPL_ACTION_ERROR' => 'Public:dispatch_jump',
    // 'TMPL_ACTION_SUCCESS' => 'Public:dispatch_jump',
    // 'ERROR_PAGE'=>'Public:dispatch_error_jump',
    // 'SHOW_ERROR_MSG' =>  true,    // 显示错误信息
    // 'TMPL_EXCEPTION_FILE' => 'Public:exception',//异常模板
    // 'TMPL_EXCEPTION_FILE'   =>  APP_PATH.'Public/tyre_manage.tpl',// 异常页面的模板文件
    
    // 'ERROR_PAGE' =>'/Public/dispatch_error_jump.html',//部署后错误页面
    // 'TMPL_ACTION_ERROR' => __PUBLIC__.'/common/tpl/error',
);