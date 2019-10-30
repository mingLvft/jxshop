<?php
namespace Home\Model;
use http\Cookie;
use Think\Model;

class CartModel extends Model{
    protected $fields = array('id','user_id','goods_id','goods_attr_ids','goods_count');

    //作用就是实现具体商品信息加入购物车
    public function addCart($goods_id,$goods_count,$attr){
        //将属性信息做一个从小到大的排序操作
        sort($attr); //目的就是为了考虑后期库存量的检查
        //将属性信息转换为字符串形式
        $goods_attr_ids = $attr?implode(',',$attr):'';
        //实现库存量检查
        $res = $this->checkGoodsNumber($goods_id,$goods_count,$goods_attr_ids);
        if(!$res){
            $this->error = '库存不足';
            return false;
        }
        //获取用户的id标识
        $user_id = session('user_id');
        if($user_id){
            //说明用户已经登录 接下来数据的操作去操作对应的数据表
            //根据当前要写入的数据信息判断数据库中是否存在 如果存在直接更新对应的数量否则直接写入即可
            $map = array(
                'user_id' => $user_id,
                'goods_id' => $goods_id,
                'goods_attr_ids' => $goods_attr_ids,
            );
            $info = $this->where($map)->find();
            if ($info){
                //说明目前数据已经存在 已经存在需要更新对应的数量
                $this->where($map)->setField("goods_count",$goods_count+$info['goods_count']);
            }else{
                //说明目前数据不存在 直接写入数据即可
                $map['goods_count'] = $goods_count;
                $this->add($map);
            }
        }else{
            //表示用户没有登录 对应的应该操作cookie中的数据
            //规定关于商品加入购物车cookie中记录数据 使用cart的名称 对于数据从php中的数组转换为字符串是通过序列化操作来完成
            $cart = unserialize(cookie('cart'));
            //先判断目前添加的上商品信息是否存在
            //首先先拼接处对应的key下标 array_key_exists 检查数组里是否有指定的键名或索引
            // 键存储  $goods_id.'-'.$goods_attr_ids 值存储goods_count数量
            $key = $goods_id.'-'.$goods_attr_ids;
            if(array_key_exists($key,$cart)){
                //说明目前添加的商品信息已经存在
                $cart[$key] += $goods_count;
            }else{
                //说明目前添加的商品信息不存在
                $cart[$key] = $goods_count;
            }
            //处理完之后需要将最新的数据再次写入cookie
            cookie('cart',serialize($cart));
        }
        return true;
    }

    //作用就是实现商品库存的检查
    public function checkGoodsNumber($goods_id,$goods_count,$goods_attr_ids){
        //1.检查总的库存量 (唯一属性)
        $goods = D('Admin/Goods')->where("id = $goods_id")->find();
        if($goods['goods_number'] < $goods_count){
            //表示目前库存不够
            return false;
        }
        //2.单选属性检查对于的属性组合库存量
        if($goods_attr_ids){
            $where = "goods_id = $goods_id and goods_attr_ids = '$goods_attr_ids'";
            $number = M('GoodsNumber')->where($where)->find();
            if(!$number || $number['goods_number'] < $goods_count){
                //表示库存量不足
                return false;
            }
        }
        return true;
    }

    //具体实现购物车cookie中的数据转移到数据库中
    public function cookie2db(){
        //获取cookie中购物车的数据
        $cart = unserialize(cookie('cart'));
        //获取用户的id标识
        $user_id = session('user_id');
        if(!$user_id){
            return false;
        }
        foreach ($cart as $key => $value){
            //先将目前的下标对于的商品id以及属性值组合拆分出来
            $tmp = explode('-',$key);
            //先拼接条件查询当前商品信息是否存在
            $map = array(
                'user_id' => $user_id,
                'goods_id' => $tmp[0],
                'goods_attr_ids' => $tmp[1],
            );
            $info = $this->where($map)->find();
            if($info){
                //说明目前的商品信息存在 直接更新对应的信息即可
                $this->where($map)->setField("goods_count",$value+$info['goods_count']);
            }else{
                //说明目前的商品信息不存在 直接将数据写入即可
                $map['goods_count'] = $value;
                $this->add($map);
            }
        }
        //将目前的cookie中的数据清空掉
        cookie('cart',null);
    }

    //获取购物车中商品的具体信息
    public function getList(){
        //1.获取当前购物车中对应的信息
        $user_id = session('user_id');
        if ($user_id){
            //表示用户已经登录，可以从数据库中获取购物车的数据
            $data = $this->where("user_id = $user_id")->select();
        }else{
            //直接从cookie中获取对应的购物车数据
            $cart = unserialize(cookie('cart'));
            //将没有登录的购物车数据转换为数据库中格式
            foreach ($cart as $key => $value){
                $tmp = explode('-',$key);
                $data[] = array(
                    'goods_id' => $tmp[0],
                    'goods_attr_ids' => $tmp[1],
                    'goods_count' => $value
                );
            }
        }
        //2.根据购物车中商品的id标识获取商品信息
        $goodsModel = D('Admin/Goods');
        foreach ($data as $key => $value){
            //获取具体的商品信息
            $goods = $goodsModel->where('id =' .$value['goods_id'])->find();
            //根据商品是否处于促销状态设置价格
            if($goods['cx_price'] > 0 && $goods['start'] < time() && $goods['end'] > time()){
                //处于促销状态因此设置对于的shop_price为促销价格
                $goods['shop_price'] = $goods['cx_price'];
            }
            $data[$key]['goods'] = $goods;
            //3.根据商品对应的属性值的组合获取对应的属性名称跟属性值
            if($value['goods_attr_ids']){
                //获取商品属性信息
                $attr = M('GoodsAttr')->alias('a')->join("left join jx_attribute as b on a.attr_id=b.id")
                    ->field('a.attr_values,b.attr_name')->where("a.id in ({$value['goods_attr_ids']})")->select();
                $data[$key]['attr'] = $attr;
            }
        }
        return $data;
    }

    //实现计算购物车总金额
    public function getTotle($data){
        $count = $price = 0;
        foreach ($data as $key => $value){
            $count += $value['goods_count'];
            $price += $value['goods_count'] * $value['goods']['shop_price'];
        }
        return array('count'=>$count,'price'=>$price);
    }

    //实现购物车删除
    public function dels($goods_id,$goods_attr_ids){
        $goods_attr_ids = $goods_attr_ids?$goods_attr_ids:'';
        $user_id = session('user_id');
        if($user_id){
            $where = "user_id = $user_id and goods_id = $goods_id and goods_attr_ids = '$goods_attr_ids'";
            $this->where($where)->delete();
        }else{
            $cart = unserialize(cookie('cart'));
            //手动的拼接当前商品对于的key信息
            $key = $goods_id.'-'.$goods_attr_ids;
            unset($cart[$key]);
            //将最新的数据再次写入到cookie中
            cookie('cart',serialize($cart));
        }
    }

    //具体实现对购物车中商品数量的更新
    public function updateCount($goods_id,$goods_attr_ids,$goods_count){
        //增加判断目前$goods_count值为0时不进行更新
        if($goods_count <= 0){
            return false;
        }
        $goods_attr_ids = $goods_attr_ids?$goods_attr_ids:'';
        $user_id = session('user_id');
        if($user_id){
            $where = "user_id = $user_id and goods_id = $goods_id and goods_attr_ids = '$goods_attr_ids'";
            $this->where($where)->setField('goods_count',$goods_count);
        }else{
            $cart = unserialize(cookie('cart'));
            //手动的拼接当前商品对于的key信息
            $key = $goods_id.'-'.$goods_attr_ids;
            $cart[$key] = $goods_count;
            //将最新的数据再次写入到cookie中
            cookie('cart',serialize($cart));
        }
    }
}