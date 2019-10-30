<?php
namespace Admin\Controller;

class AdminController extends CommonController{
    //管理员的添加
    public function add(){
        if(IS_GET){
            //获取所有角色
            $role = D('Role')->select();
            $this->assign('role',$role);
            $this->display();
        }else{
            $model = D('Admin');
            $data = $model->create();
            if(!$data){
                $this->error($model->getError());
            }
            $res = $model->add($data);
            if (!$res){
                $this->error($model->getError());
            }
            $this->success('写入数据成功');
        }
    }

    //管理员列表显示
    public function index(){
        $model = D('Admin');
        $data = $model->listData();
        $this->assign('data',$data);
        $this->display();
    }

    //管理员的删除
    public function dels(){
        $admin_id = intval(I('get.admin_id'));
        if($admin_id <= 1){
            $this->error('参数错误');
        }
        $res = D('Admin')->remove($admin_id);
        if($res === false){
            $this->error('删除失败');
        }
        $this->success('删除成功');
    }

    //管理的修改
    public function  edit(){
        $model = D('Admin');
        if(IS_GET){
            $admin_id = intval(I('get.admin_id'));
            //获取用户名密码以及对应的角色id
            $info = $model->findOne($admin_id);
            //获取所有的角色信息
            $role = D('Role')->select();
            $this->assign('info',$info);;
            $this->assign('role',$role);;
            $this->display();
        }else{
            $data = $model->create();
            if(!$data){
                $this->error($model->getError());
            }
            if($data['id'] <= 1){
                $this->error('参数错误');
            }
            $model->update($data);
            $this->success('修改成功',U('index'));
        }
    }
}