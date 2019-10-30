<?php
namespace Admin\Controller;
//使用链式继承的方式  A ->B ->C   A：Idex B：中间控制器Common C: 父类 Controller
class IndexController extends CommonController {
    public function index(){
        $this->display();
    }
    public function top(){
        $this->display();
    }
    public function menu(){
        //赋值权限信息给导航菜单显示
        $this->assign('menus',$this->user['menus']);
        $this->display();
    }
    public function main(){
        $this->display();
    }
}