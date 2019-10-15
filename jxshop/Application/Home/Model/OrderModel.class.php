<?php
namespace Home\Model;
use Think\Model;

class OrderModel extends Model{

    public function order(){
        //1.获取购物车中商品的信息
        $cartModel = D('Cart');
        $data = $cartModel->getList();
        if(!$data){
            $this->error = '购物车中没有商品';
            return false;
        }
        //2.根据每一个商品做一个库存检查
        foreach ($data as $key => $value){
            //针对每个商品进行检查
            $status = $cartModel->checkGoodsNumber($value['goods_id'],$value['goods_count'],$value['goods_attr_ids']);
            if(!$status){
                $this->error = '库存量不足';
                return false;
            }
        }
        //3.向订单总表写入数据
        //计算购物车中商品的总价格
        $total = $cartModel->getTotle($data);
        $order = array(
            'user_id' => session('user_id'),
            'addtime' => time(),
            'total_price' => $total['price'],
            'name' => I('post.name'),
            'address' => I('post.address'),
            'tel' => I('post.tel'),
        );
        $order_id = $this->add($order);
        //4.向商品订单详情表写入数据
        foreach ($data as $key => $value){
            $goods_order[] = array(
                'order_id' => $order_id,
                'goods_id' => $value['goods_id'],
                'goods_attr_ids' => $value['goods_attr_ids'],
                'price' => $value['goods']['shop_price'],
                'goods_count' => $value['goods_count'],
            );
        }
        M('OrderGoods')->addAll($goods_order);
        //5.减少商品对应的库存量
        foreach ($data as $key => $value){
            //1.先需要将商品表中的总库存减少
            M('Goods')->where('id =' .$value['goods_id'])->setDec('goods_number',$value['goods_count']);
            //实现增加商品对应的销量
            M('Goods')->where('id='.$value['goods_id'])->setInc('sale_number',$value['goods_count']);
            //2.根据商品的单选属性组合减少对应的库存量
            if($value['goods_attr_ids']){
                M('GoodsNumber')->where('goods_id ='.$value['goods_id'].' and goods_attr_ids='."'".$value['goods_attr_ids']."'")->setDec('goods_number',$value['goods_count']);
            }
        }
        //6.清空购物车数据
        $user_id = session('user_id');
        $cartModel->where("user_id = $user_id")->delete();
        //订单号
        $order['id'] = $order_id;
        return $order;
    }
}