<?php
namespace Home\Model;
use Think\Model;

class CommentModel extends Model{
    protected $fields = array('id','user_id','goods_id','addtime','content','star','good_number');

    public function _before_insert(&$data){
        //评论信息入库
        $data['addtime'] = time();
        $data['user_id'] = session('user_id');
    }

    public function _after_insert($data){
        //评论印象入库
        $name = I('post.name');
        $old = I('post.old');
        foreach ($old as $key => $value){
            M('Impression')->where('id='.$value)->setInc('count');
        }
        //将数据转换为数组格式
        $name = explode(',',$name);
        //对目前接受到的印象信息进行去重操作
        $name = array_unique($name);
        foreach ($name as $key => $value){
            if(!$value){
                continue;
            }
            //判断当前的印象在数据库中是否存在，如果存在，更新对应的count值，如果不存在 直接数据写入
            $where = array('goods_id' => $data['goods_id'],'name' => $value);
            $model = M('Impression');
            $res = $model->where($where)->find();
            if ($res){
                //说明目前的印象已经存在
                $model->where($where)->setInc('count');
            }else{
                $where['count'] = 1;
                $model->add($where);
            }
        }
        //实现商品表中评论总数的增加功能
        M('Goods')->where('id='.$data['goods_id'])->setInc('plcount');
    }

    //根据当前商品的id标识获取对应的评论信息
    public function getList($goods_id){
        //获取当前页
        $p = I('get.p');
        $pagesize = 3;
        //计算出目前数据总数
        $count = $this->where("goods_id = $goods_id")->count();
        //实例化分页类 获取分页信息
        $page = new \Think\Page($count,$pagesize);
        //启用使用锚点
        $page->setConfig('is_anchor',true);
        $show = $page->show();
        //获取对应的评论信息
        $list = $this->alias('a')->field('a.*,b.username')->join('left join jx_user as b on a.user_id = b.id')->where('a.goods_id='.$goods_id)->page($p,$pagesize)->select();
        return array('list'=>$list,'page'=>$show);
    }

}