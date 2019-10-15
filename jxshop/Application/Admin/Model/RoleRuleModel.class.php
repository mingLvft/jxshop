<?php
namespace Admin\Model;
/*
 * 角色权限模型
 */
class RoleRuleModel extends CommonModel{
    //定义字段
    protected $fields = array('id','role_id','rule_id');

    //分配角色权限
    public function disfetch($role_id,$rules){
        //1.将当前角色对应的权限删除
        $this->where("role_id = $role_id")->delete();
        //2.将最新的权限信息写入数据库
        foreach ($rules as $key => $value){
            $list[] = array(
                'role_id' => $role_id,
                'rule_id' => $value
            );
        }
        $this->addAll($list);
    }

    //根据角色id获取对应的权限信息
    public function getRules($role_id){
        return $this->where("role_id = $role_id")->select();
    }
}