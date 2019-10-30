<?php
namespace Admin\Model;

use Think\Think;

class GoodsModel extends CommonModel{
    //自定义字段
    protected $fields = array('id','goods_name','goods_sn','cate_id','market_price',
        'shop_price','goods_img','goods_thumb','goods_body','is_hot',
        'is_rec','is_new','addtime','isdel','is_sale','type_id','goods_number',
        'cx_price','start','end','plcount','sale_number');

    //自定义自动验证
    protected $_validate = array(
        array('goods_name','require','商品名称必须填写',1),
        array('cate_id','checkCategory','分类必须填写',1,'callback'),
        array('market_price','currency','市场价格格式不对'),
        array('shop_price','currency','本店价格格式不对'),
    );

    //对分类进行验证
    public function checkCategory($cate_id){
        $cate_id = intval($cate_id);
        if($cate_id > 0){
            return true;
        }
        return false;
    }

    //实现商品信息修改
    public function update($data){
        //实现关于促销商品时间的格式化操作
        if($data['cx_price'] > 0){
            //设置商品为促销商品
            $data['start'] = strtotime($data['start']);
            $data['end'] = strtotime($data['end']);
        }else{
            $data['cx_price'] = 0.00;
            $data['start'] = 0;
            $data['end'] = 0;
        }
        $goods_id = $data['id'];
        //解决商品的货号问题
        $goods_sn = $data['goods_sn'];
        if(!$goods_sn){
            //没有货号自动生成
            $data['goods_sn'] = 'JX' . uniqid();
        }else{
            //用户有提交货号 检查货号是否重复 并且需要将自己以前的货号排除在外
            $res = $this->where("goods_sn = '$goods_sn' AND id != $goods_id")->find();
            if($res){
             $this->error = '货号重复';
             return false;
            }
        }
        //解决扩展分类的问题
        //删除之前的扩展分类
        $extCateModel = D('GoodsCate');
        $extCateModel->where("goods_id = $goods_id")->delete();
        //将最新的扩展分类写入数据
        //接受提交的扩展分类
        $ext_cate_id = I('post.ext_cate_id');
        $extCateModel->insertExtCate($ext_cate_id,$goods_id);

        //实现图片上传
        $res = $this->UploadImg();
        if($res){
            $data['goods_img'] = $res['goods_img'];
            $data['goods_thumb'] = $res['goods_thumb'];
        }
        //实现属性修改功能
        //1、删除当前商品对应的属性信息
        $goodsAttrModel = D('GoodsAttr');
        $goodsAttrModel->where("goods_id = $goods_id")->delete();
        //将最新的数据写入数据库
        $attr = I('post.attr');
        $goodsAttrModel->insertAttr($attr,$goods_id);

        //实现商品相册图片上传以及入库
        //1、将商品图片上传释放
        unset($_FILES['goods_img']);
        $upload = new \Think\Upload();
        $info = $upload->upload();
        foreach ($info as $key => $value){
            //上传之后的图片地址
            $goods_img = 'Uploads/' . $value['savepath'] . $value['savename'];
            //实现缩略图的制作
            $img = new \Think\Image();
            $img->open($goods_img);
            //制作缩略图
            $goods_thumb = 'Uploads/' . $value['savepath'] . 'thumb_' . $value['savename'];
            $img->thumb(100,100)->save($goods_thumb);
            $list[] = array(
                'goods_id' => $goods_id,
                'goods_img' => $goods_img,
                'goods_thumb' => $goods_thumb
            );
        }
        if($list){
            M('GoodsImg')->addAll($list);
        }
        return $this->save($data);

    }

    //使用TP的钩子函数
    public function _before_insert(&$data){
        //实现关于促销商品时间的格式化操作
        if($data['cx_price'] > 0){
            //设置商品为促销商品
            $data['start'] = strtotime($data['start']);
            $data['end'] = strtotime($data['end']);
        }else{
            $data['cx_price'] = 0.00;
            $data['start'] = 0;
            $data['end'] = 0;
        }
        //添加时间
        $data['addtime'] = time();
        //处理货号
        if (!$data['goods_sn']){
            //没有题号货号自动生成
            $data['goods_sn'] = 'JX' .uniqid();
        }else{
            //有提交货号
            $info = $this->where('goods_sn='.$data['goods_sn'])->find();
            if($info){
                $this->error = '货号重复';
                return false;
            }
        }

        //实现图片上传
        $res = $this->UploadImg();
        if($res){
            $data['goods_img'] = $res['goods_img'];
            $data['goods_thumb'] = $res['goods_thumb'];
        }
    }

    //在add完成之后自动执行 (钩子函数)
    public function _after_insert($data){
        $goods_id = $data['id'];
        //接受提交的扩展分类
        $ext_cate_id = I('post.ext_cate_id');
        D('GoodsCate')->insertExtCate($ext_cate_id,$goods_id);
        //属性的入库
        $attr = I('post.attr');
        D('GoodsAttr')->insertAttr($attr,$goods_id);

        //实现商品相册图片上传以及入库
        //1、将商品图片上传释放
        unset($_FILES['goods_img']);
        $upload = new \Think\Upload();
        $info = $upload->upload();
        foreach ($info as $key => $value){
            //上传之后的图片地址
            $goods_img = 'Uploads/' . $value['savepath'] . $value['savename'];
            //实现缩略图的制作
            $img = new \Think\Image();
            $img->open($goods_img);
            //制作缩略图
            $goods_thumb = 'Uploads/' . $value['savepath'] . 'thumb_' . $value['savename'];
            $img->thumb(100,100)->save($goods_thumb);
            $list[] = array(
                'goods_id' => $goods_id,
                'goods_img' => $goods_img,
                'goods_thumb' => $goods_thumb
            );
        }
        if($list){
            M('GoodsImg')->addAll($list);
        }
    }

    //获取商品信息
    public function listData($isdel=1){
        //1.定义每页显示的数据条数
        $pagesize = 5;
        //拼接
        $where = 'isdel=' .$isdel;
        //接受提交的分类id
        $cate_id = intval(I('get.cate_id'));
        if($cate_id){
            //拼接where子句
            //1.根据提交的分类id表示查询出商品表中的cate_id值等于该ID标识的即可
            //2.根据提交的分类id 先查询出当前分类下的所有的子分类。然后在将提交的分类id与该分类所有对应的子分类进行组合
            //作为条件进行查询。此时可以使用Mysql中的in语法进行查询
            //3.查询出商品的扩展分类的id等于当前分类或者是当前分类所对应的子分类。此时能够得到商品id 然后在根据商品id获取
            //对应的商品信息

            //1.根据当前的分类id获取子分类
            $cateModel = D('Category');
            $tree = $cateModel->getChildren($cate_id);
            //将提交的当前分类的id追加到数组中 $tree记录了提交的商品id及子分类id
            $tree[] = $cate_id;
            //将$tree数组转换为字符串格式
            $children = implode(',',$tree);

            //获取扩展分类的商品id
            $ext_goods_ids = M('GoodsCate')->group('goods_id')->where("cate_id in ($children)")->select();
            if($ext_goods_ids){
                foreach ($ext_goods_ids as $key => $value){
                    $goods_ids[] = $value['goods_id'];
                }
                //将数组转换成字符串格式
                $goods_ids = implode(',',$goods_ids);
            }
            //组合where子句
            if(!$goods_ids){
                //没有商品的扩展分类满足条件
                $where .= " AND cate_id in ($children)";
            }else{
                $where .= " AND (cate_id in ($children) OR id in ($goods_ids))";
            }
        }
        //接受提交的推荐状态
        $intro_type = I('get.intro_type');

        if($intro_type) {
            //限制只能使用此三个推荐作为条件
            if ($intro_type == 'is_new' || $intro_type == 'is_rec' || $intro_type == 'is_hot') {
                $where .= " AND $intro_type = 1";
            }
        }
        //接受上下架
        $is_sale = intval(I('get.is_sale'));
        if($is_sale == 1){
            //表单提交的1表示上架
            $where .= " AND is_sale = 1";
        }elseif($is_sale == 2){
            //表单提交的2表示下架
            $where .= " AND is_sale = 0";
        }
        //接受关键词
        $keyword = I('get.keyword');
        if($keyword){
            $where .= " AND goods_name like '%$keyword%'";
        }
        //2.获取数据总数
        $count = $this->where($where)->count();
        //3.计算出分页导航
        $page = new \Think\Page($count,$pagesize);
        $show = $page->show();
        //5.获取当前的页码
        $p = intval(I('get.p'));
        //6.获取具体的数据
        $data = $this->where($where)->page($p,$pagesize)->select();
        //返回时需要将数据及分页的导航数据都返回
        return array('pageStr'=>$show,'data'=>$data);
    }
    //商品伪删除
    public function setStastus($goods_id,$isdel=0){
        return $this->where("id = $goods_id")->setField('isdel',$isdel);
    }

    //商品的彻底删除
    public function remove($goods_id){
        //1.删除商品的图片
        $goods_info  = $this->findOneById($goods_id);
        if(!$goods_info){
            return false;
        }
        unlink($goods_info['goods_img']);
        unlink($goods_info['goods_thumb']);
        //2.删除商品的扩展分类
        D('GoodsCate')->where("goods_id = $goods_id")->delete();
        //3.删除商品的基本信息
        $this->where("id = $goods_id")->delete();
        return true;
    }

    //封装图片上传
    public function UploadImg(){
        //判断是否有图片上传
        if(!isset($_FILES['goods_img']) || $_FILES['error'] == 0){
            return false;
        }
        //实现图片上传
        $upload = new \Think\Upload();
        $info = $upload->uploadOne($_FILES['goods_img']);
        if(!$info){
            $this->error = $upload->getError();
        }
        //在代码中图片地址使用不用使用/
        //在html代码中显示图片时必须使用/ 表示域名对应的根目录
        //上传之后的图片地址
        $goods_img = 'Uploads/' . $info['savepath'] . $info['savename'];

        //实现缩略图的制作
        $img = new \Think\Image();
        $img->open($goods_img);
        //制作缩略图
        $goods_thumb = 'Uploads/' . $info['savepath'] . 'thumb_' . $info['savename'];
        $img->thumb(450,450)->save($goods_thumb);
        //保存数据
        return array('goods_img' => $goods_img,'goods_thumb' => $goods_thumb);
    }

    //根据传递的参数返回热卖、推荐、新品的商品信息
    public function getRecGoods($type){
        return $this->where("is_sale = 1 and $type = 1")->limit(5)->select();
    }

    //获取当前真该促销的商品信息
    public function getCrazyGoods(){
        //查询条件 1.商品正在销售 2.当前时间处于促销的开始时间和结束时间之间  3.促销价格大于0
        $where = 'is_sale=1 and cx_price>0 and start<'.time().' and end>'.time();
        return $this->where($where)->limit(5)->select();
    }

    //获取某个分类下的商品信息
    public function getList(){
        //获取当前分类id
        $cate_id = I('get.id');
        //获取当前商品分类下的子分类
        $children = D('Admin/Category')->getChildren($cate_id);
        //将当前分类追加到子分类中
        $children[] = $cate_id;
        //将目前的分类信息转换字符串格式
        $children = implode(',',$children);
        //组装具体的查询条件
        $where = "is_sale = 1 and cate_id in($children)";
        //计算当前分类下对应的价格筛选条件

        //获取当前分类下所有商品对应的最大价格以及最小价格
        //获取当前分类下所有的商品的id组合
        $goods_info = $this->field('max(shop_price) as max_price,min(shop_price) as min_price,count(id) as goods_count,group_concat(id) as goods_ids')->where($where)->find();

        //根据商品个数判断是否需要显示出价格区间
        if($goods_info['goods_count'] > 1){
            $cha = $goods_info['max_price'] - $goods_info['min_price'];
            //通过判断计算出具体电视的价格区间个数
            if($cha < 100){
                $sec = 1; //具体显示的价格区间的个数
            }elseif ($cha < 500){
                $sec = 2;
            }elseif ($cha < 1000){
                $sec = 3;
            }elseif ($cha < 5000){
                $sec = 4;
            }elseif ($cha < 10000){
                $sec = 5;
            }else{
                $sec = 6;
            }
            $price = array(); //保存具体的每一个价格区间对应的值
            $first = ceil($goods_info['min_price']); //具体开始的价格
            $zl = ceil($cha/$sec);  //每个价格区间增加的具体数量价格
            //进行循环运算每一个价格区间对应的开始价格跟结束价格
            for ($i=0; $i<$sec; $i++){
                //组装每一个价格区间对应的开始跟结束数值
                $price[] = $first.'-'.($first+$zl);
                $first += $zl;
            }
        }
        //接受价格条件进行查询
        if(I('get.price')){
            //有具体的价格条件传递
            //将目前接受的价格转换为数组格式  作为一个查询条件
            $tmp = explode('-',I('get.price'));
            $where .= ' and shop_price>'.$tmp[0].' and shop_price<'.$tmp[1];
        }
        //获取商品的属性信息
        if($goods_info['goods_ids']){
            $attr = M('GoodsAttr')->alias('a')->field('distinct a.attr_id,a.attr_values,b.attr_name')->join('left join jx_attribute b on a.attr_id=b.id')->where('a.goods_id in ('.$goods_info['goods_ids'].')')->select();
            //将目前已有的数据转换为三位数组的格式
            foreach ($attr as $key => $value){
                $attrwhere[$value['attr_id']][] = $value;
            }
        }
        //根据属性值条件获取商品信息
        if(I('get.attr')){
            //需要使用属性值进行商品筛选
            //将目前所接受的属性值的条件转换为数组格式。转换的目的是为了使用tp的条件进行查询
            $attrParms = explode(',',I('get.attr'));
            //获取属性对应的商品id
            $goods = M('GoodsAttr')->field('group_concat(goods_id) as goods_id')->where(array('attr_values'=>array('in',$attrParms)))->find();
            if ($goods['goods_id']){
                //组装具体的where条件
                $where .= " and id in ({$goods['goods_id']})";
            }
        }
        //接收当前所在的页码
        $p = I('get.p');
        //定义每页显示的数据条数
        $pagesize = 8;
        //计算总数
        $count = $this->where($where)->count();
        //计算具体的分类信息
        $page = new \Think\Page($count,$pagesize);
        $show = $page->show();
        //根据当前所在的页码获取对应的商品数据
        //接受排序字段
        $sort = I('get.sort')?I('get.sort'):'sale_number';

        $list = $this->where($where)->page($p,$pagesize)->order($sort.' desc')->select();
        return array('list'=>$list,'page'=>$show,'price'=>$price,'attrwhere'=>$attrwhere);
    }
}