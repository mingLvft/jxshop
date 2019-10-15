<?php
namespace Home\Controller;

class IndexController extends CommonController {
    public function index(){
        //控制器是否展开分类
        $this->assign('is_show',1);
        //获取热卖商品信息
        $goodsModel = D('Admin/Goods');
        $hot = $goodsModel->getRecGoods('is_hot');
        $this->assign('hot',$hot);
        //获取推荐商品
        $rec = $goodsModel->getRecGoods('is_rec');
        $this->assign('rec',$rec);
        //获取新品商品
        $new = $goodsModel->getRecGoods('is_new');
        $this->assign('new',$new);
        //获取当前正在促销的商品信息
        $crazy = $goodsModel->getCrazyGoods();
        $this->assign('crazy',$crazy);
        //获取楼层信息
        $floor = D('Admin/Category')->getFloor();
        $this->assign('floor',$floor);
        $this->display();
    }
    //测试使用U函数生成的URL地址
    public function testUrl(){
        //第二个参数可以是数组或字符串形式 作为URL地址上的参数
        echo U('index','id=2');
    }
}