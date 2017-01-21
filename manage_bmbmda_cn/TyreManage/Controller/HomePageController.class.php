<?php
namespace TyreManage\Controller;
use Think\Controller;
class HomePageController extends CommonController {
    public function index(){

        $this->display('Index/Index');
    }

    //首页
    public function Main(){
    }
}