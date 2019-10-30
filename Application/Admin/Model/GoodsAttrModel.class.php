<?php
namespace Admin\Model;

class GoodsAttrModel extends CommonModel{
    //自定义字段
    protected $fields = array('id','goods_id','attr_id','attr_values');

    public function insertAttr($attr,$goods_id){
        foreach ($attr as $key => $value){
            foreach ($value as $v){
                $attr_list[] = array(
                    'goods_id' => $goods_id,
                    'attr_id' => $key,
                    'attr_values' => $v
                );
            }
        }
        D('GoodsAttr')->addAll($attr_list);
    }

    //实现根据商品id获取对应的属性值及属性信息
    public function getSigleAttr($goods_id){
        $data = $this->alias('a')->join('left join jx_attribute as b on a.attr_id = b.id')->field('a.*,b.attr_name,b.attr_type,b.attr_input_type,b.attr_value')->where("a.goods_id = $goods_id AND b.attr_type = 2")->select();
        //将获取到的结果转换为三位数组，转换的目的就是为了方便模板中显示
        foreach ($data as $key => $value){
            //根据属性的id进行区分
            $list[$value['attr_id']][] = $value;
        }
        return $list;
    }
}