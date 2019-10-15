<?php
namespace Admin\Model;
/*
 * 商品类型模型
 */
class TypeModel extends CommonModel{
    //定义字段
    protected $fields = array('id','type_name');
    //自动验证
    protected $_validate = array(
        array('type_name','require','类型名称必须填写!'),
        array('type_name','','  类型名重复',1,'unique')
    );

    //获取商品类型信息
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
    public function remove($type_id){
        $this->where("id = $type_id")->delete();
    }
}