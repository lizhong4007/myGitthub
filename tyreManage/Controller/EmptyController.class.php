<?php
namespace tyreManage\Controller;
use Think\Controller; 
class EmptyController extends Controller{ 
    function _empty(){ 
	    header("HTTP/1.0 404 Not Found");//使HTTP返回404状态码 
	    echo '返回404状态码 ';die;
	   // $this->display("Public:404"); 
	} 
} 
?>