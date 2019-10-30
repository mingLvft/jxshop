<?php
namespace Admin\Controller;
use Think\Controller;
//公共控制器
class CommonController extends Controller{
    //标识是否进行权限认证
    public $is_check_rule = true;
    //保存用户的信息  包括基本信息 角色id 权限信息
    public $user = array();
    public function __construct(){
        parent::__construct();
        //判断当前用户是否登录
        $admin = cookie('admin');
        if(!$admin){
            $this->error('没有登录',U('Login/login'));
        }

        //读取当前用户对应的文件信息
        $this->user = S('user_' .$admin['id']);
        if (!$this->user){
            //将当前用户的信息保存到user属性中
            $this->user = $admin;
            //根据用户的id获取对应的角色id
            $role_info = M('AdminRole')->where("admin_id =" .$admin['id'])->find();
            //将角色id存储到user属性中
            $this->user['role_id'] = $role_info['role_id'];
            $ruleModel = D('Rule');
            if($this->user['role_id'] == 1){
                //超级管理员 （保存用户权限信息）
                $this->is_check_rule = false;  //不验证权限
                //保存权限信息
                $rule_list = $ruleModel->select();
            }else{
                //普通管理员 （保存用户权限信息）
                //1.根据角色id获取对应的权限id
                //2.根据权限id获取对应的权限信息
                $rules = D('RoleRule')->getRules($role_info['role_id']);
                //将查询到的权限id的二维数组转换为一维数组
                foreach($rules as $key => $value){
                    $rules_ids[] = $value['rule_id'];
                }
                //将一维数组转换为字符串格式方便使用in语法
                $rules_ids = implode(',',$rules_ids);
                //根据权限id 获取对应的权限信息
                $rule_list = $ruleModel->where("id in ($rules_ids)")->select();
            }
            //将用户对应的二维数组的权限信息转换为一维数组并且保存到user属性中
            foreach ($rule_list as $key => $value){
                //将对应的模型、控制器、方法名称进行拼接
                $this->user['rules'][] = strtolower($value['module_name'] .'/' .$value['controller_name'] .'/' .$value['action_name']);
                //考虑到导航信息的显示
                if($value['is_show'] == 1){
                    $this->user['menus'][] =$value;
                }
            }
            //读取数据完成之后需要将信息写入到文件中
            S('user_' .$admin['id'],$this->user);
        }
        //针对超级管理员不进行权限认证
        if($this->user['role_id'] ==1){
            $this->is_check_rule = false;
        }
        if($this->is_check_rule){
            //增加人具备的访问权限
            $this->user['rules'][] = 'admin/index/index';
            $this->user['rules'][] = 'admin/index/top';
            $this->user['rules'][] = 'admin/index/menu';
            $this->user['rules'][] = 'admin/index/main';
            //普通管理员
            //获取当前用户访问的URL地址
            $action = strtolower(MODULE_NAME .'/' .CONTROLLER_NAME .'/' .ACTION_NAME);
            if (!in_array($action,$this->user['rules'])){
                if(IS_AJAX){
                    $this->ajaxReturn(array('status' => 0,'msg' => '没有权限'));
                }else{
                    $this->error('没有权限');exit();
                }
            }
        }
    }

    public function _empty(){
        $this->display('Empty/index');
    }
}