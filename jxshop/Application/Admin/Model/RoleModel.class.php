<?php
namespace Admin\Model;
/*
 * 角色模型
 */
class RoleModel extends CommonModel{
    //定义字段
    protected $fields = array('id','role_name');
    //自动验证
    protected $_validate = array(
        array('role_name','require','角色名称必须填写!'),
        array('role_name','','角色名重复',1,'unique')
    );

    //获取角色信息
    public function listData(){
        //定义页尺寸
        $pagesize = 3;
        //计算数据总数
        $count = $this->count();
        //生成分页导航信息
        $page = new \Think\Page($count,$pagesize);
        $show = $page->show();
        //接受当前所在的页面
        $p = intval(I('get.p'));
        $list = $this->page($p,$pagesize)->select();
        return array('pageStr'=>$show,'list'=>$list);
    }

    //删除
    public function remove($role_id){
        $this->where("id = $role_id")->delete();
    }
}