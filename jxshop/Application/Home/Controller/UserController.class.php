<?php
namespace Home\Controller;

class UserController extends CommonController{

    //实现注册
    public function regist(){
        if(IS_GET){
            $this->display();
        }else{
            $username = I('post.username');
            $password = I('post.password');
            $checkcode = I('post.checkcode');
            //检查验证码是否正确
            $obj = new \Think\Verify();
            if(!$obj->check($checkcode)){
                $this->ajaxReturn(array('status'=>0,'msg'=>'验证码错误'));
            }
            //实例化模型对象 调用方法入库口
            $model = D('User');
            $res = $model->regist($username,$password);
            if(!$res){
                $this->ajaxReturn(array('status'=>0,'msg'=>$model->getError()));
            }
            $this->ajaxReturn(array('status'=>1,'msg'=>'ok'));
        }
    }

    //生成验证码
    public function code(){
        //如果gd库也开启了但是就是不能正常的生成验证码可以使用ob_clean()实现
        $config = array(
            'fontSize'  =>  12,              // 验证码字体大小(px)
            'useCurve'  =>  false,            // 是否 画混淆曲线
            'useNoise'  =>  false,            // 是否添加杂点
            'imageH'    =>  38,               // 验证码图片高度
            'imageW'    =>  90,               // 验证码图片宽度
            'length'    =>  4,               // 验证码位数
            'fontttf'   =>  '4.ttf',              // 验证码字体，不设置随机获取
        );
        //实例化验证码类
        $obj = new \Think\Verify($config);
        //输出验证码
        $obj->entry();
    }

    //登陆
    public function login(){
        if(IS_GET){
            $this->display();
        }else{
            $username = I('post.username');
            $password = I('post.password');
            $checkcode = I('post.checkcode');
            //检查验证码是否正确
            $obj = new \Think\Verify();
            if(!$obj->check($checkcode)){
                $this->ajaxReturn(array('status'=>0,'msg'=>'验证码错误'));
            }
            //实例化模型对象 调用方法入库口
            $model = D('User');
            $res = $model->login($username,$password);
            if(!$res){
                $this->ajaxReturn(array('status'=>0,'msg'=>$model->getError()));
            }
            $this->ajaxReturn(array('status'=>1,'msg'=>'ok'));
        }
    }

    //退出登录
    public function logout(){
        session('user',null);
        session('user_id',null);
        $this->redirect('/');
    }
}