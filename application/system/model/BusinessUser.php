<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/5/15
 * Time: 下午1:07
 */

namespace app\system\model;


use think\Model;
use think\Session;
use app\system\model\RelationRoleUg;
use app\system\model\RelationUserGroup;
use app\system\model\RelationRoleFd;

class BusinessUser extends Model
{
    /**
     * @param string $username
     * @param string $password
     * @return array
     * @throws \think\exception\DbException
     * 用户登录校验
     */
    public function user_check($username='', $password = ''){
        if($username== '' || $username == null) {
            return [
                'msg'=>'请输入用户名',
                'flag'=>false
            ];
        }
        if($password== '' || $password == null) {
            return [
                'msg'=>'请输入密码',
                'flag'=>false
            ];
        }
        $user_id= BusinessUser::where('user_name',$username)->value('user_id');
        if(!$user_id){
            return [
                'msg'=>'用户不存在',
                'flag'=>false
            ];
        }
        $user_info = BusinessUser::get(['user_name'=>$username, 'password'=>$password]);
        if($user_info){
            Session::set('user_info', $user_info);
            print_r($user_info);
            return [
                'msg'=>'验证通过',
                'flag'=>true
            ];
        }else{
            return [
                'msg'=>'密码错误',
                'flag'=>false
            ];
        }
    }

    public function get_user_menu(){
        //1、获取用户角色role_id列表
        $user_id = Session::get('user_info')->user_id;
        $user_role_ids =  RelationRoleUg::where('ug_id', $user_id)->where('type', 0)->column('role_id');
        //2、获取用户组role_id列表
        $group_ids =  RelationUserGroup::where('user_id', $user_id)->column('group_id');
        $group_role_ids = RelationRoleUg::where('ug_id', 'in', $group_ids)->where('type', 1)->column('role_id');
        //3、角色id取并集
        $role_ids = array_merge($user_role_ids, $group_role_ids);
        //4、获取功能id列表
        $function_ids = RelationRoleFd::where('role_id', 'in', $role_ids)->column('function_id');
        //获取角色功能列表
        $menu = new BusinessFunction();
        $menu_list = $menu->where('function_id', 'in', $function_ids)->order('level_type','asc')->order('sort', 'asc')->select();
        return $menu_list;

    }
}