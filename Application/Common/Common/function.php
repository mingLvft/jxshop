<?php

//生成商品列表中连接地址
function myU($name,$value){
    //获取当前浏览器上已经拥有的属性值的参数信息
    $attr = I('get.attr');
    if($name == 'sort'){
        //将目前的排序字段保存到$sort变量中
        $sort = $value;
        $price = I('get.price');
    }elseif ($name == 'price'){
        //将目前的价格信息保存到变量中
        $price = $value;
        $sort = I('get.sort');
    }elseif ($name == 'attr'){
        //根据属性值生成连接地址
        //可以实现多个属性值作为条件
        if(!$attr){
            $attr = $value;
        }else{
            //说明目前已经拥有了属性值对应的条件
            //将已经拥有的属性值参数信息转换为数组
            $attr = explode(',',$attr);
            $attr[] = $value;
            //对目前已经拥有的属性值信息进行去重操作
            $attr = array_unique($attr);
            //数组转字符串
            $attr = implode(',',$attr);
        }
    }
    return U('Category/index').'?id='.I('get.id').'&sort='.$sort.'&price='.$price.'&attr='.$attr;
}