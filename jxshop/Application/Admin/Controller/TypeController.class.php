<?php
namespace Admin\Controller;

class TypeController extends CommonController{
    //商品类型的添加
    public function add(){
        if(IS_GET){
            $this->display();
        }else{
            $model = D('Type');
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

    //商品类型列表显示
    public function index(){
        $model = D('Type');
        $data = $model->listData();
        $this->assign('data',$data);
        $this->display();
    }

    //商品类型的删除
    public function dels(){
        $type_id = intval(I('get.type_id'));
        if($type_id <= 0){
            $this->error('参数错误');
        }
        $res = D('Type')->remove($type_id);
        if($res === false){
            $this->error('删除失败');
        }
        $this->success('删除成功');
    }

    //商品类型的编辑
    public function edit(){
        $model = D('Type');
        if(IS_GET){
            $type_id = intval(I('get.type_id'));
            $info = $model->findOneById($type_id);
            $this->assign('info',$info);
            $this->display();
        }else{
            $data = $model->create();
            if(!$data){
                $this->error($model->getError());
            }
            if($data['id'] <= 0){
                $this->error('参数错误');
            }
            $model->save($data);
            $this->success('修改成功',U('index'));
        }
    }


}