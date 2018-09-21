<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/7/8
 * Time: 上午9:51
 */

namespace app\system\model;

use app\common\CommonModel;
use traits\model\SoftDelete;
use think\Session;
use think\Db;

class Customer extends CommonModel
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
                    ->where('name', 'like', '%' . $search_content . '%')
                    ->whereOr('id_number', 'like', '%' . $search_content . '%')
                    ->whereOr('phone', 'like', '%' . $search_content . '%')
                    ->whereOr('qq', 'like', '%' . $search_content . '%')
                    ->whereOr('wechat', 'like', '%' . $search_content . '%')
                    ->whereOr('area', 'like', '%' . $search_content . '%')
                    ->whereOr('weibo', 'like', '%' . $search_content . '%')
                    ->count();
                $list = $this
                    ->where('name', 'like', '%' . $search_content . '%')
                    ->whereOr('id_number', 'like', '%' . $search_content . '%')
                    ->whereOr('phone', 'like', '%' . $search_content . '%')
                    ->whereOr('qq', 'like', '%' . $search_content . '%')
                    ->whereOr('wechat', 'like', '%' . $search_content . '%')
                    ->whereOr('area', 'like', '%' . $search_content . '%')
                    ->whereOr('weibo', 'like', '%' . $search_content . '%')
                    ->field('customer_id, shop_id, company_id, classify, 
                    name, sex, age, id_number, phone, qq, wechat, weibo, province, 
                    city, area, address, add_time, add_user, update_time, update_user')
                    ->limit(($page - 1) * $limit, $limit)
                    ->order('update_time', 'desc')
                    ->select();
            } else {
                $list = $this
                    ->field('customer_id, shop_id, company_id, classify, 
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
        if ($info = $this->where('customer_id', $id)->find()->data) {
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
                'shop_id' => input('shop_id'),
                'company_id' => input('company_id'),
                'classify' => input('classify'),
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
                'update_user' => Session::get('user_info')->user_id,
                'update_time' => date('Y-m-d H:i:s', time())
            ];
            if ($user_info = Session::get('user_info')) {
                if ($classify = $user_info->classify == 'common') {
                    $insert_data = array_merge($insert_data, [
                        'shop_id' => $user_info->shop_id,
                        'company_id' => $user_info->company_id
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
                        'company_id' => $user_info->company_id
                    ]);
                } else if ($classify == 'admin') {
                    $insert_data = array_merge($insert_data, [
                        'shop_id' => input('shop_id') ? input('shop_id') : '',
                        'company_id' => input('company_id') ? input('company_id') : ''
                    ]);
                }
            }
            if (input('customer_id')) {
                //更新数据前将之前的数据进行备份
                $customer_info = $this->get_info(input('customer_id'));
                $record_data = [
                    'customer_id' => input('customer_id'),
                    'last_content' => json_encode($customer_info, JSON_FORCE_OBJECT),
                    'update_time' => date('Y-m-d H:i:s', time()),
                    'update_user' => Session::get('user_info')->user_id
                ];
                Db::table('tb_customer_record')->insert($record_data);
                $update_data = array_merge($insert_data, ['customer_id' => input('customer_id')]);
                if ($this->update($update_data)) {
                    $this->json_success('更新成功');
                } else {
                    $this->json_fail('更新失败～');
                }
            } else {
                $insert_data = array_merge($insert_data,
                    [
                        'add_user' => Session::get('user_info')->user_id,
                        'add_time' => date('Y-m-d H:i:s', time())
                    ]
                );
                if ($this->insert($insert_data)) {
                    $this->json_success('添加成功');
                } else {
                    $this->json_fail('添加失败～');
                }
            }
        }
    }

    public function delete_info($id)
    {
        if ($id) {
            $info = $this->where('customer_id', $id)->count();
            if (!$info) { //根据用户id查询不到用户数据
                $this->json_fail('数据不存在');
                return;
            }
            if ($delete_result = $this::destroy($id)) {
                $this->json_success($delete_result);
            }
        } else { //参数未传递
            $this->json_fail('参数为空(id)');
        }
    }

    public function record_aud()
    {
        if (request()->isGet()) {
            $this->json_fail('请求方法异常，当前只支持post，不支持get');
        }
        if (request()->isPost()) {
            //基本数据获取
            $insert_data = [
                'customer_id' => input('customer_id'),
                'user_id' => Session::get('user_info')->user_id,
                'track_title' => input('track_title'),
                'track_time' => input('track_time'),
                'track_content' => input('track_content'),
                'add_time' => date('Y-m-d H:i:s', time())
            ];
            if (Db::table('tb_customer_track')->insert($insert_data)) {
                $this->redirect('system/customer/add_record?id=' . input('company_id'));
            } else {
                $this->json_fail('添加失败～');
            }
        }
    }

    public function get_customer_record_list($company_id)
    {
        return Db::table('tb_customer_track')
            ->where('customer_id', $company_id)
            ->order('track_time', 'desc')
            ->select();
    }

    public function get_max_date_record($company_id)
    {
        return Db::table('tb_customer_track')
            ->where('customer_id', $company_id)
            ->field('max(track_time) as track_time')
            ->find();
    }

    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 根据权限获取可以展示的用户数据
     */
    public function get_all_customer_list()
    {
        $list = $this
            ->field('customer_id, shop_id, company_id, classify, 
                    name, sex, age, id_number, phone, qq, wechat, weibo, province, 
                    city, area, address, add_time, add_user, update_time, update_user')
            ->order('update_time', 'desc')
            ->select();
        $this->json_success($list);
    }
}