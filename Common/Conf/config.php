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
    'DEFAULT_MODULE'        =>  'TyreWWW',  // 默认模块
    'DEFAULT_CONTROLLER'    =>  'HomePage', // 默认控制器名称
    'DEFAULT_ACTION'        =>  'index', // 默认操作名称
    'MULTI_MODULE' => false,//隐藏TyreWWW

    'APP_SUB_DOMAIN_DEPLOY'=>1,
    'APP_SUB_DOMAIN_RULES'=>array(
        'manage.bmbmda.com'=>'TyreManage',
        'img.bmbmda.com'=>'TyreImage',
        'www.bmbmda.com'=>'TyreWWW',
       
    ),
    'MODULE_SITE'=>array(
        'TyreManage'=>'manage.bmbmda.com',
        'TyreImage'=>'img.bmbmda.com',
        'TyreWWW'=>'www.bmbmda.com',
    ),
    //网址配置
    'BM_SITE'=>array(
        'UPLOAD_FILE_URL'=>'http://img.bmbmda.com',//上传文件地址
        'DEFAULT_IMAGE'=>'http://img.bmbmda.com/default.jpg',//默认图片域名
        'DEFAULT_SITE'=>'http://www.bmbmda.com',//默认网址
        'DEFAULT_TITLE'=>'蹦蹦哒',//默认网址
        ),
    'URL_MODEL'=>2,//去掉index.php
    'URL_PATHINFO_DEPR'=>'-',// 更改PATHINFO参数分隔符

    
    
    
    //跳转页面
    /*'TMPL_ACTION_ERROR' => 'Public:dispatch_jump',
    'TMPL_ACTION_SUCCESS' => 'Public:dispatch_jump',
    'ERROR_PAGE'=>'Public:dispatch_error_jump',
    'SHOW_ERROR_MSG' =>  true,    // 显示错误信息
    'TMPL_EXCEPTION_FILE' => 'Public:exception',//异常模板
    'TMPL_EXCEPTION_FILE'   =>  APP_PATH.'Public/tyre_manage.tpl',// 异常页面的模板文件*/
    
    // 'ERROR_PAGE' =>'/Public/dispatch_error_jump.html',//部署后错误页面
    // 'TMPL_ACTION_ERROR' => __PUBLIC__.'/common/tpl/error',
    'TMPL_EXCEPTION_FILE' =>'404.html',//部署后错误页面
    'ERROR_PAGE' =>'404.html',//部署后错误页面
    'TMPL_ACTION_ERROR' =>'404.html',//部署后错误页面
);