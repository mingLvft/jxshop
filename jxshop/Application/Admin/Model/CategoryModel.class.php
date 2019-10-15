<?php
namespace Admin\Model;
class CategoryModel extends CommonModel{
    //自定义字段
    protected $fields = array('id','cname','parent_id','isrec');
    //自动验证
    protected $_validate = array(
        array('cname','require','分类名称必须填写'),
    );

    //获取某个分类的子分类
    public function getChildren($id){
        //先获取所有的分类信息
        $data = $this->select();
        //再对获取的信息进行格式化
        $list = $this->getTree($data,$id,1,false);
        foreach ($list as $key => $value){
            $tree[] = $value['id'];
        }
        return $tree;
    }

    //获取格式化之后的数据
    public function getCateTree($id=0){
        //先获取所有的分类信息
        $data = $this->select();
        //再对获取的信息进行格式化
        $list = $this->getTree($data,$id);
        return $list;
    }

    //格式化分类信息
    public function getTree($data,$id=0,$lev=1,$iscache=true){
        static $list = array();
        //根据参数决定是否需要重置
        if(!$iscache){
            $list = array();
        }
        foreach($data as $key => $value){
            if($value['parent_id']==$id){
                $value['lev'] = $lev;
                $list[] = $value;
                //使用递归的方式偶去分类下的子分类
                $this->getTree($data,$value['id'],$lev+1);
            }
        }
        return $list;
    }

    public function dels($id){
        //如果删除的分类下有子分类不允许删除
        $result = $this->where('parent_id ='.$id)->find();
        if($result){
            return false;
        }
        return $this->where('id ='.$id)->delete();
    }

    public function update($data){
        //需要过滤掉设置父分类为自己或者自己下的子分类
        //1. 根据要修改的分类的标识  获取到自己下的所有的子分类
        $tree = $this->getCateTree($data['id']);
        $tree[] = array('id'=>$data['id']);
        //将自己添加到不能修改的数组
        //2. 根据提交的parent_id的值 判断如果等于当前修改的分类id或者是当前分类下的所有子分类的id不容许修改
        foreach ($tree as $key => $value){
            if($data['parent_id']==$value['id']){
                $this->error='不能设置子分类为父分类';
                return false;
            }
        }
        return $this->save($data);
    }

    //获取楼层信息 包括楼层的分类信息以及商品信息
    public function getFloor(){
        //1.获取所有定级分类
        $data = $this->where("parent_id = 0")->select();
        //根据顶级分类标识获取对应的二级分类及推荐的二级分类信息
        foreach ($data as $key => $value){
            //获取二级分类
            $data[$key]['son'] = $this->where('parent_id =' .$value['id'])->select();
            //获取推荐的二级分类信息
            $data[$key]['recson'] = $this->where('isrec=1 and parent_id =' .$value['id'])->select();
            //根据每一个楼层推荐的二级分类信息获取对应的商品数据
            foreach ($data[$key]['recson'] as $k => $v){
                //$V 代表每一个推荐分类信息
                $data[$key]['recson'][$k]['goods'] = $this->getGoodsByCateId($v['id']);
            }
        }
        return $data;
    }

    //根据分类id标识获取对应的商品信息
    public function getGoodsByCateId($cate_id,$limit=8){
        //1.获取当前分类下面子分类信息
        $children = $this->getChildren($cate_id);
        //2.将当前分类的标识追加到对应的子分类中
        $children[] = $cate_id;
        //3.将$children格式化为字符串的格式目的就是为了使用Mysql中的in语法
        $children = implode(',',$children);
        //4.通过目前的分类信息获取商品数据
        $goods = D('Goods')->where("is_sale=1 and cate_id in ($children)")->limit($limit)->select();
        return $goods;
    }
}