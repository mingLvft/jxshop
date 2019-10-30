<?php
namespace Admin\Model;

class AttributeModel extends CommonModel{
    //自定义字段
    protected $fields = array('id','attr_name','type_id','attr_type','attr_input_type','attr_value');
    //自定义验证规则
    protected $_map = array(
        array('attr_name','require','属性名称必须填写'),
        array('type_id','require','属性所对应的类型必须填写'),
        array('attr_type','1,2','属性类型只能为单选或者唯一',1,'in'),
        array('attr_input_type','1,2','属性录入方法只能为手工或者列表选择',1,'in'),
        );

    //获取属性信息
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
        //实现将type_id装换为具体的类型信息 可以有两种
        //1、可以使用mysql的链表查询
        //2、可以使用替换的方式实现
            //1.先获取到所有的类型信息
        $type = D('Type')->select();
            //2.再将类型信息转换为使用主键ID作为索引的数组
        foreach ($type as $key => $value){
            $typeinfo[$value['id']] = $value;
        }
            //3.循环具体的数据，在根据type_id进行一个替换操作即可
        foreach ($list as $key => $value){
            $list[$key]['type_id'] = $typeinfo[$value['type_id']]['type_name'];
        }
        return array('pageStr'=>$show,'list'=>$list);
    }

    //属性的删除
    public function remove($attr_id){
        return $this->where("id = $attr_id")->delete();
    }
}