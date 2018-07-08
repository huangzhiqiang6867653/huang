<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/7/7
 * Time: 下午5:08
 */

namespace app\system\model;

use app\common\CommonModel;
use traits\model\SoftDelete;
use think\Session;
use think\Db;

class User extends CommonModel
{

    //软删除
    use SoftDelete;
    protected $deleteTime = 'delete_flag';

    public function getSexAttr($value)
    {
        $status = [0 => '女', 1 => '男'];
        return $status[$value];
    }

    /**
     * @param int $page
     * @param $limit
     * @param $search_content
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取列表分页数据
     *
     */
    public function get_list($page = 1, $limit, $search_content)
    {
        try {
            $limit = $limit ? $limit : config('paginate.list_rows');
            if ($search_content) {
                $count = $this
                    ->where('login_name', 'like', '%' . $search_content . '%')
                    ->whereOr('name', 'like', '%' . $search_content . '%')
                    ->whereOr('id_number', 'like', '%' . $search_content . '%')
                    ->whereOr('phone', 'like', '%' . $search_content . '%')
                    ->whereOr('qq', 'like', '%' . $search_content . '%')
                    ->whereOr('wechat', 'like', '%' . $search_content . '%')
                    ->whereOr('area', 'like', '%' . $search_content . '%')
                    ->whereOr('weibo', 'like', '%' . $search_content . '%')
                    ->count();
                $list = $this
                    ->where('login_name', 'like', '%' . $search_content . '%')
                    ->whereOr('name', 'like', '%' . $search_content . '%')
                    ->whereOr('id_number', 'like', '%' . $search_content . '%')
                    ->whereOr('phone', 'like', '%' . $search_content . '%')
                    ->whereOr('qq', 'like', '%' . $search_content . '%')
                    ->whereOr('wechat', 'like', '%' . $search_content . '%')
                    ->whereOr('area', 'like', '%' . $search_content . '%')
                    ->whereOr('weibo', 'like', '%' . $search_content . '%')
                    ->field('user_id, shop_id, company_id, login_name, classify, 
                    name, sex, age, id_number, phone, qq, wechat, weibo, province, 
                    city, area, address, add_time, add_user, update_time, update_user')
                    ->limit(($page - 1) * $limit, $limit)
                    ->order('update_time', 'desc')
                    ->select();
            } else {
                $list = $this
                    ->field('user_id, shop_id, company_id, login_name, classify, 
                    name, sex, age, id_number, phone, qq, wechat, weibo, province, 
                    city, area, address, add_time, add_user, update_time, update_user')
                    ->limit(($page - 1) * $limit, $limit)
                    ->order('update_time', 'desc')
                    ->select();
                $count = $this->count();
            }
            $this->list_success_return($count, $list);
        } catch (Exception $e) {
            $this->list_error_return($e->getMessage());
        }
    }

    /**
     * @param $id
     * @return array|object|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取单条记录
     */
    public function get_info($id)
    {

        if ($info = $this->where('user_id', $id)->find()->data) {
            return $info;
        } else {
            return '查询结果为空';
        }
    }

    /**
     * 数据操作
     */
    public function aud()
    {
        if (request()->isGet()) {
            $this->json_fail('请求方法异常，当前只支持post，不支持get');
        }
        if (request()->isPost()) {
            //基本数据获取
            $insert_data = [
                'login_name' => input('login_name'),
                'password' => '111111',
                'name' => input('name'),
                'sex' => input('sex'),
                'age' => input('age'),
                'id_number' => input('id_number'),
                'phone' => input('phone'),
                'qq' => input('qq'),
                'wechat' => input('wechat'),
                'weibo' => input('weibo'),
                'province' => input('province'),
                'city' => input('city'),
                'area' => input('area'),
                'address' => input('address'),
                'add_user' => Session::get('user_info')->user_id,
                'add_time' => date('Y-m-d H:i:s', time()),
                'update_user' => Session::get('user_info')->user_id,
                'update_time' => date('Y-m-d H:i:s', time())
            ];
            if ($user_info = Session::get('user_info')) {
                if ($classify = $user_info->classify == 'common') {
                    $insert_data = array_merge($insert_data, [
                        'shop_id' => $user_info->shop_id,
                        'company_id' => $user_info->company_id,
                        'classify' => 'common'
                    ]);
                } else if ($classify == 'shop') {
                    $insert_data = array_merge($insert_data, [
                        'shop_id' => $user_info->shop_id,
                        'company_id' => $user_info->company_id,
                        'classify' => 'common'
                    ]);
                } else if ($classify == 'company') {
                    $insert_data = array_merge($insert_data, [
                        'shop_id' => input('shop_id') ? input('shop_id') : '',
                        'company_id' => $user_info->company_id,
                        'classify' => input('classify') ? input('classify') : 'common'
                    ]);
                } else if ($classify == 'admin') {
                    $insert_data = array_merge($insert_data, [
                        'shop_id' => input('shop_id') ? input('shop_id') : '',
                        'company_id' => input('company_id') ? input('company_id') : '',
                        'classify' => input('classify') ? input('classify') : 'common'
                    ]);
                }
            }
            if (input('user_id')) {
                $update_data = array_merge($insert_data, ['user_id' => input('user_id')]);
                if ($this->update($update_data)) {
                    $this->json_success('更新成功');
                } else {
                    $this->json_fail('更新失败～');
                }
            } else {
                if ($this->insert($insert_data)) {
                    $this->json_success('添加成功');
                } else {
                    $this->json_fail('添加失败～');
                }
            }
        }
    }

    /**
     * @param $id
     * 删除用户(逻辑删除)
     */
    public function delete_info($id)
    {
        if ($id) {
            $info = $this->where('user_id', $id)->count();
            if (!$info) { //根据用户id查询不到用户数据
                $this->json_fail('数据不存在');
                return;
            }
            if ($delete_result = $this::destroy($id)) {
                $this->json_success($delete_result);
            }
        } else { //参数user_id未传递
            $this->json_fail('参数为空(id)');
        }
    }

    /**
     * @param string $username
     * @param string $password
     * @return array
     * @throws \think\exception\DbException
     * 用户登录
     */
    public function user_check($username = '', $password = '')
    {
        if ($username == '' || $username == null) {
            return [
                'msg' => '请输入用户名',
                'flag' => false
            ];
        }
        if ($password == '' || $password == null) {
            return [
                'msg' => '请输入密码',
                'flag' => false
            ];
        }
        $user_id = $this->where('login_name', $username)->value('user_id');
        if (!$user_id) {
            return [
                'msg' => '用户不存在',
                'flag' => false
            ];
        }
        $user_info = $this->get(['login_name' => $username, 'password' => $password]);
        if ($user_info) {
            Session::set('user_info', $user_info);
            if ($shop_id = $user_info->shop_id) {
                $shop_info = Db::table('tb_shop')->where('shop_id', $shop_id);
                Session::set('shop_info', $shop_info);
            }
            if ($company_id = $user_info->company_id) {
                $company_info = Db::table('tb_company')->where('company_id', $company_id);
                Session::set('company_info', $company_info);
            }
            return [
                'msg' => '验证通过',
                'flag' => true
            ];
        } else {
            return [
                'msg' => '密码错误',
                'flag' => false
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
    public function get_user_menu()
    {
        //1、获取用户角色role_id列表
        $user_id = Session::get('user_info')->user_id;
        $user_role_ids = RelationRoleUg::where('ug_id', $user_id)->where('type', 0)->column('role_id');
        //2、获取用户组role_id列表
        $group_ids = RelationUserGroup::where('user_id', $user_id)->column('group_id');
        $group_role_ids = RelationRoleUg::where('ug_id', 'in', $group_ids)->where('type', 1)->column('role_id');
        //3、角色id取并集
        $role_ids = array_merge($user_role_ids, $group_role_ids);
        //4、获取功能id列表
        $function_ids = RelationRoleFd::where('role_id', 'in', $role_ids)->column('function_id');
        //获取角色功能列表
        $menu = new BusinessFunction();
        $menu_list = $menu->where('function_id', 'in', $function_ids)->order('level_type', 'asc')->order('sort', 'asc')->select();
        return $menu_list;
    }

    /**
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取公司列表数据
     */
    public function get_company_list()
    {
        $list = Db::table('tb_company')
            ->where('pay_flag', 0)
            ->field('company_id,company_name')
            ->order('company_id', 'desc')
            ->select();
        return $list;
    }

    /**
     * @param $company_id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 根据公司id获取门店列表数据
     */
    public function get_shop_list($company_id)
    {
        $list = Db::table('tb_shop')
            ->where('pay_flag', 0)
            ->where('company_id', $company_id)
            ->field('shop_id,shop_name')
            ->order('shop_id', 'desc')
            ->select();
        return $list;
    }

    public function get_shop_list_ajax($company_id)
    {
        if ($company_id) {
            $list = Db::table('tb_shop')
                ->where('pay_flag', 0)
                ->where('company_id', $company_id)
                ->field('shop_id,shop_name')
                ->order('shop_id', 'desc')
                ->select();
            $this->json_success($list);
        } else {
            $this->json_fail('参数为空');
        }

    }
}