<?php
namespace Admin\Controller;
use Think\Controller;
//公共类 不需要继承中间控制器
class LoginController extends Controller{

    //验证登陆
    public function login(){
        if(IS_GET){
            $this->display();
        }else{
            //接收验证码进行比对
            $captcha = I('post.captcha');
            $verify = new \Think\Verify();
            //验证  验证码
            $res = $verify->check($captcha);
            if(!$res){
                $this->error('验证码不正确');
            }
            //接收用户密码调用模型方法进行比对
            $username = I('post.username');
            $password = I('post.password');
            $model = D('Admin');
            $res = $model->login($username,$password);
            if(!$res){
                $this->error($model->getError());
            }
            $this->success('登陆成功',U('Index/index'));
        }
    }

    //生成验证码
    public function verify(){
        //如果gd库也开启了但是就是不能正常的生成验证码可以使用ob_clean()实现
        $config = array(
            'fontSize'  =>  12,              // 验证码字体大小(px)
            'useCurve'  =>  false,            // 是否画混淆曲线
            'useNoise'  =>  false,            // 是否添加杂点
            'imageH'    =>  38,               // 验证码图片高度
            'imageW'    =>  90,               // 验证码图片宽度
            'length'    =>  4,               // 验证码位数
            'fontttf'   =>  '4.ttf',              // 验证码字体，不设置随机获取
        );
        //实例化验证码类
        $verify = new \Think\Verify($config);
        //输出验证码
        $verify->entry();
    }
}