<?php
namespace Home\Controller;

class GoodsController extends CommonController{
    //显示商品详细
    public function index(){
        $goods_id = intval(I('get.goods_id'));
        if($goods_id <= 0){
            //参数不正常
            //重定向到商城首页 即没有任何提示直接跳转 对应重定向传递的URL地址不需要使用U函数生成 因为在tp内部对参数会再次使用U函数
            $this->redirect('Index/index');
        }
        $goodsModel = D('Admin/Goods');
        $goods = $goodsModel->where("is_sale = 1 and id = $goods_id")->find();
        if(!$goods){
            //针对商品不存在或者处于下架状态
            $this->redirect('Index/index');
        }
        //将商品描述信息格式化
        $goods['goods_body'] = htmlspecialchars_decode($goods['goods_body']);
        //如果当前商品处于促销阶段 价格显示出为促销价格
        if($goods['cx_price']>0 && $goods['start'] <time() && $goods['end']>time()){
            $goods['shop_price'] = $goods['cx_price'];
        }
        $this->assign('goods',$goods);
        //获取商品对应的相册信息
        $pic = M('GoodsImg')->where("goods_id = $goods_id")->select();
        $this->assign('pic',$pic);
        //获取当前商品对应的属性信息
        $attr = M('GoodsAttr')->alias('a')->field('a.*,b.attr_name,b.attr_type')->join('left join jx_attribute as b on a.attr_id = b.id')->where("a.goods_id = $goods_id")->select();
        //将已有的属性信息根据单选和唯一进行拆分
        foreach ($attr as $key => $value){
            if($value['attr_type'] == 1){
                //表示唯一属性
                $uniqid[] = $value;
            }else{
                //单选属性 需要格式化为三维数组 因为模板显示需要两 次循环显示。并且对于同一个属性 需要显示在一起因此可以使用属性id作为一维的下标
                    $sigle[$value['attr_id']][] = $value;
            }
        }

        $this->assign('uniqid',$uniqid);
        $this->assign('sigle',$sigle);
        //获取当前商品对应的评论信息
        $commentModel = D('Comment');
        $comment = $commentModel->getList($goods_id);
        $this->assign('comment',$comment);
        //获取当前商品对应的印象数据
        $buyer = M('Impression')->where('goods_id ='.$goods_id)->limit(8)->select();
        $this->assign('buyer',$buyer);
        $this->display();
    }

    //实现评论的数据入库功能
    public function comment(){
        //增加对用户的登陆判断
        $this->checkLogin();
        $model = D('Comment');
        $data = $model->create();
        if(!$data){
            $this->error('参数不对');
        }
        $model->add($data);
        $this->success('写入成功');
    }


    //评论有用值的增加
    public function goodNumber(){
        $comment_id = intval(I('post.comment_id'));
        $model = D('Comment');
        $info = $model->where("id = $comment_id")->find();
        if(!$info){
            $this->ajaxReturn(array('status'=>0,'msg'=>'error'));
        }
        $model->where("id = $comment_id")->setField('good_number',$info['good_number']+1);
        $this->ajaxReturn(array('status'=>1,'msg'=>'ok','good_number' => $info['good_number']+1));
    }
}