<?php
namespace Admin\Controller;
class RuleController extends CommonController{
    //实现权限的添加
    public function add(){
        if(IS_GET){
            //获取格式化之后的权限信息
            $model = D('Rule');
            $cate = $model->getCateTree();
            //将信息赋值给模板
            $this->assign('cate',$cate);
            $this->display();
        }else{
            //数据入库
            $model = D('Rule');
            //创建数据对象
            $data = $model->create();
            if (!$data){
                $this->error($model->getError());
            }
            $insetid = $model->add($data);
            if (!$insetid){
                $this->error('数据写入失败');
            }
            $this->success('写入成功');
        }

    }

    //权限的列表显示
    public function index(){
        //获取格式化之后的权限信息
        $model = D('Rule');
        $list = $model->getCateTree();
        $this->assign('list',$list);
        $this->display();
    }

    //实现商品权限的删除
    public function dels(){
        $id = intval(I('get.id'));
        if($id <= 0){
            $this->error('参数不对! ');
        }
        $model = D('Rule');
        //调用模型中的删除方法实现删除操作
        $res = $model->dels($id);
        if($res === false){
            $this->error('删除失败');
        }
        $this->success('删除成功');
    }

    //实现商品权限的修改
    public function edit(){
        if(IS_GET){
            //显示要编辑的权限信息
            $id = intval(I('get.id'));
            $model = D('Rule');
            //根据id参数获取该权限的信息
            $info = $model->findOneById($id);
            $this->assign('info',$info);
            //获取所有的权限信息
            $cate = $model->getCateTree();
            $this->assign('cate',$cate);
            $this->display();
        }else{
            $model = D('Rule');
            $data = $model->create();
            if(!$data){
                $this->error($model->getError());
            }
            $res = $model->update($data);
            if($res === false){
                $this->error($model->getError());
            }
            $this->success('修改成功',U('index'));
        }
    }
}