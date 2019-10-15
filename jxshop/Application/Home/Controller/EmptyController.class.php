<?php
//声明命名空间
namespace Home\Controller;
//声明类并继承父类
class EmptyController extends CommonController{
    public function _empty(){
        $this->display('Empty/index');
    }
}