<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/5/15
 * Time: 下午1:07
 */

namespace app\system\model;


use app\common\CommonModel;
use think\Session;
use traits\model\SoftDelete;
use app\system\model\RelationRoleUg;
use app\system\model\RelationUserGroup;
use app\system\model\RelationRoleFd;

class BusinessUser extends CommonModel
{
    //软删除
    use SoftDelete;
    protected $deleteTime = 'delete_flag';
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
        $user_id= $this->where('user_name',$username)->value('user_id');
        if(!$user_id){
            return [
                'msg'=>'用户不存在',
                'flag'=>false
            ];
        }
        $user_info = $this->get(['user_name'=>$username, 'password'=>$password]);
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

    /**
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取当前用户权限菜单
     */
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

    /**
     * @param int $page
     * @param $limit
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * h获取用户列表数据
     */
    public function get_user_list($page = 1, $limit) {
        try{
            $limit = $limit?$limit:config('paginate.list_rows');
            $count = $this->count();
            $list = $this
                ->field('user_id,user_name, password, create_time')
                ->limit(($page - 1)* $limit,$limit)
                ->order('update_time', 'desc')
                ->select();
            $this->list_success_return($count,$list);
        }catch (Exception $e) {
            $this->list_error_return($e->getMessage());
        }
    }

    /**
     * @param $uer_id
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取用户个人信息
     */
    public function get_user_info($uer_id) {
        if($user_info = $this->where('user_id', $uer_id)->where('delete_flag', 0)->find()->data){
            $this->json_success($user_info);
        }else{
            $this->json_fail('查询结果为空');
        }
    }

    public function delete_user_info($uer_id){
        if($uer_id){
            $user_info = $this->where('user_id', $uer_id)->count();
            if(!$user_info){ //根据用户id查询不到用户数据
                $this->json_fail('用户不存在');
                return;
            }
            if($delete_result = $this::destroy($uer_id)){
                $this->json_success($delete_result);
            }
        }else{ //参数user_id未传递
            $this->json_fail('参数为空(user_id)');
        }
    }
}