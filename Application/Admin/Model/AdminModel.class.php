<?php
namespace Admin\Model;
/*
 * 管理员模型
 */

class AdminModel extends CommonModel{
    //自定义字段
    protected $fields = array('id','username','password');
    //自动验证
    protected $validate = array(
        array('username','require','用户名必须填写'),
        array('username','','用户名重复',1,'unique'),
        array('password','require','密码必须填写'),
    );
    //自动完成
    protected $_auto = array(
        array('password','md5',3,'function')
    );

    //使用TP的钩子函数 实现中间表的入库
    protected function _after_insert($data){
        $admin_role = array(
            'admin_id' => $data['id'],
            'role_id' => I('post.role_id'),
        );
        M('AdminRole')->add($admin_role);
    }

    public function listData(){
        //定义页尺寸
        $pagesize = 3;
        //计算数据总数
        $count = $this->count();
        //生成分页导航信息
        $page = new \Think\Page($count,$pagesize);
        $show = $page->show();
        //接受当前所在的页码
        $p = intval(I('get.p'));
        $list = $this->alias('a')->field("a.*,c.role_name")->join("left join jx_admin_role as b on a.id=b.admin_id")->join("left join jx_role as c on b.role_id=c.id")->page($p,$pagesize)->select();
        return array('pageStr'=>$show,'list'=>$list);
    }

    public function remove($admin_id){
        //开启事物
        $this->startTrans();
        //1.删除对应的用户信息 jx_admin
        $userStatus = $this->where("id = $admin_id")->delete();
        if(!$userStatus){
            $this->rollback();
            return false;
        }
        //2.删除对应的角色信息 jx_admin_role
        $roleStatus = M('AdminRole')->where("admin_id = $admin_id")->delete();
        if(!$roleStatus){
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }

    //根据用户的id获取用户的基本信息以及角色的id
    public function findOne($admin_id){
        return $this->alias('a')->field("a.*,b.role_id")->join("left join jx_admin_role as b on a.id = b.admin_id")->where("a.id = $admin_id")->find();
    }

    public function update($data){
        $role_id = intval(I('post.role_id'));
        //修改用户的基本信息
        $this->save($data);
        //修改用户对应的角色
        M('AdminRole')->where('admin_id =' .$data['id'])->save(array('role_id' => $role_id));
    }

    //验证用户登陆
    public function login($username,$password){
        //1.根据用户名查询出用户信息
        $userinfo = $this->where("username = '$username' ")->find();
        if(!$username){
            $this->error = '用户名不存在';
            return false;
        }
        //2.根据密码进行比对
        if($userinfo['password'] != md5($password)){
            $this->error = '密码不存在';
            return false;
        }
        //说明该用户信息是正确的可以登录
        cookie('admin',$userinfo);
        return true;
    }
}