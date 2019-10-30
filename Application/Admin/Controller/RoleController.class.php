<?php
namespace Admin\Controller;

class RoleController extends CommonController{
    //角色的添加
    public function add(){
        if(IS_GET){
            $this->display();
        }else{
            $model = D('Role');
            $data = $model->create();
            if(!$data){
                $this->error($model->getError());
            }
            $res = $model->add($data);
            if (!$res){
                $this->error($model->getError());
            }
            $this->success('添加成功');
        }
    }

    //角色列表显示
    public function index(){
        $model = D('Role');
        $data = $model->listData();
        $this->assign('data',$data);
        $this->display();
    }

    //角色的删除
    public function dels(){
        $role_id = intval(I('get.role_id'));
        if($role_id <= 1){
            $this->error('参数错误');
        }
        $res = D('Role')->remove($role_id);
        if($res === false){
            $this->error('删除失败');
        }
        $this->success('删除成功');
    }

    //角色的编辑
    public function edit(){
        $model = D('Role');
        if(IS_GET){
            $role_id = intval(I('get.role_id'));
            $info = $model->findOneById($role_id);
            $this->assign('info',$info);
            $this->display();
        }else{
            $data = $model->create();
            if(!$data){
                $this->error($model->getError());
            }
            if($data['id'] <= 1){
                $this->error('参数错误');
            }
            $model->save($data);
            $this->success('修改成功',U('index'));
        }
    }

    //角色权限的赋予
    public function disfetch(){
        if (IS_GET){
            //获取当前角色拥有的权限信息
            $role_id = intval(I('get.role_id'));
            if($role_id <= 1){
                $this->error('参数错误');
            }
            $hasRules = D('RoleRule')->getRules($role_id);
            //对权限信息进行格式化操作。目的是为了方便使用TP自带的in标签
            //对应in标签要求是一个一维数组或者是字符串格式
            foreach ($hasRules as $key => $value){
                $hasRuleIds[] = $value['rule_id'];
            }
            $this->assign('hasRuleIds',$hasRuleIds);
            //获取所有权限信息
            $rule = D('Rule')->getCateTree();
            $this->assign('rule',$rule);
            $this->display();
        }else{
            $role_id = intval(I('post.role_id'));
            if($role_id <= 1){
                $this->error('参数错误');
            }
            //接受提交的权限id 此时是数组格式
            $rules = I('post.rule');
            D('RoleRule')->disfetch($role_id,$rules);
            //修改角色的权限后需要将当前角色下的所有的文件信息全部删除  （根据角色id 得到用户id 删除用户信息）
            //获取当前修改的角色下的所有的用户信息
            $user_info = M('AdminRole')->where("role_id = $role_id")->select();
            foreach ($user_info as $key => $value){
                //删除某个用户的对应的文件信息
                S('user_' .$value['admin_id'],null);
            }
            $this->success('操作成功',U('index'));
        }
    }

    //更新超级管理员用户对应的缓存文件
    public function flushAdmin(){
        //获取所有的超级管理员用户
        $user = M('AdminRole')->where("role_id = 1")->select();
        //将所有的超级管理员用户对应的缓存文件删除
        foreach ($user as $key => $value){
            S('user_' .$value['admin_id'],null);
        }
    }
}