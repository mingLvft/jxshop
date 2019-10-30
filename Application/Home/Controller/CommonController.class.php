<?php
namespace Home\Controller;
use \Think\Controller;
//继承公共控制器
class CommonController extends Controller{
    public function __construct(){
        parent::__construct();
        //获取分类信息
        $cate = D('Admin/Category')->getCateTree();
        $this->assign('cate',$cate);
    }

    //检查用户是否登录，如果没有登录直接跳转到登陆页面进行登录
    public function checkLogin(){
        $user_id = session('user_id');
        if(!$user_id){
            //没有登录
            $this->error('请先登录',U('User/login'));
        }
    }

    public function _empty(){
        $this->display('Empty/index');
    }
}