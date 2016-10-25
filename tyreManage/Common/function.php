<?php
/*check permissions*/
function checkPermission($controller = CONTROLLER_NAME,$action = ACTION_NAME){
	global $manager;
	$methods = getMethods();
	$controller = strtolower($controller);
	$action = strtolower($action);
	if( !isset($methods[$controller]['actions'][$action])){
		return true;
	}
	if(empty($manager['groupid']) && $manager['groupid'] == 0){//Administrators
		return true;
	}
	$action = str_replace($controller,'',$action);
	if(!in_array($controller.'_'.$action, $manager['permissions'])){
        return false;
    }else{
    	return true;
    }
}
/*get Methods*/
function getMethods()
{
	$modelFolder = MODULE_PATH;
	$controllerFolder = $modelFolder.'Controller/';
	$handle = opendir($controllerFolder);
	$model = str_replace('/', '', str_replace('./', '', $modelFolder));
	while ($file = readdir($handle)) {
		//去掉"“.”、“..” 和目录
		if ($file != '.' && $file != '..' && is_file($controllerFolder.$file)) {
			$class = new ReflectionClass($model.'\\Controller\\'.str_replace('.class.php', '', $file));
			$method = $class->getMethods(\ReflectionMethod::IS_PUBLIC);
			foreach ($method as $key => $value) {
				$tmp = array();
				$tmp['action']=strtolower($value->name);
				$tmp['controller']=strtolower(substr(basename(str_replace('\\', '/', $value->class)),0,-10));
				$methodcomment = $value->getDocComment();
				$tmp['descr'] = getComment($methodcomment,'@HQtag');
				if(empty($tmp['descr'])){
					continue;
				}
				$classcomment = $class->getDocComment();
				$methods[$tmp['controller']]['descr']=getComment($classcomment,'@HQtag');
				$methods[$tmp['controller']]['actions'][$tmp['action']]=$tmp;
			}
		}
	}
	//关闭句柄
	closedir ($handle);
	return $methods;

}

/*get Comments*/
function getComment($str, $tag = '') 
{ 
    if (empty($tag)) 
    { 
        return false; 
    }

    $matches = array(); 
    preg_match_all("/".$tag.":(.*)(\\r\\n|\\r|\\n)/U", $str, $matches); 
    if(!empty($matches[1][0])) 
    { 
        return trim($matches[1][0]); 
    } 

    return false; 
}
/*生成缩略图*/
function make_thumb($file = '',$width = 300,$height = 300)
{
	$image = new \Think\Image(); 
	$image->open($file);
	$file_arr = explode('/',$file);
	$y_file = APP_PATH.'/Images/thumb/'.$file_arr[3];
	make_file($y_file);
	$m_file = $y_file.'/'.$file_arr[4];
	make_file($m_file);
	$d_file = $m_file.'/'.$file_arr[5];
	$file_name = $d_file.'/'.$file_arr[6];
	// 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.jpg
	$image->thumb($width, $height)->save($file_name);

	$app_path = APP_PATH;
	$file = str_replace($app_path, '', $file);
	return $file;
}
/*生成文件*/
function make_file($file = '')
{
  if(!file_exists($file))
  {
    mkdir($file);
  }

}