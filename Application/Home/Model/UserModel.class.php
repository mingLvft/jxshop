<?php
namespace Home\Model;
use Think\Model;

class UserModel extends Model{
    protected $fields = array('id','username','password','salt');

    //实现用户信息入库
    public function regist($username,$password){
        //检查用户名是否可用
        $info = $this->where("username = '$username'")->find();
        if($info){
            $this->error = '用户名重复';
            return false;
        }
        //生成盐
        $salt = rand(100000,999999);
        //生成双重md5之后的密码
        $db_password = md5(md5($password).$salt);
        $data = array(
            'username'=>$username,
            'password'=>$db_password,
            'salt'=>$salt
        );
        return $this->add($data);
    }

    //登录
    public function login($username,$password){
        //检查用户名是否存在
        $info = $this->where("username = '$username'")->find();
        if(!$info){
            $this->error = '用户名不存在';
            return false;
        }
        //生成双重md5加密的密文 然后在与数据库中的密码进行对比
        $pwd = md5(md5($password).$info['salt']);
        if($pwd != $info['password']){
            $this->error = '密码不对';
            return false;
        }
        //保存用户的登陆状态
        session('user',$info);
        session('user_id',$info['id']);
        //实现购物车cookie中的数据转移到数据库中
        D('Cart')->cookie2db();
        return true;
    }
}