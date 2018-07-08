<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/7/8
 * Time: 上午11:13
 */

namespace app\system\model;

use app\common\CommonModel;

class Shop extends CommonModel
{

    public function getPayFlagAttr($value)
    {
        $status = [0 => '已付', 1 => '未付'];
        return $status[$value];
    }
    /**
     * @param int $page
     * @param $limit
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取列表分页数据
     */
    public function get_list($page = 1, $limit, $search_content)
    {
        try {
            $limit = $limit ? $limit : config('paginate.list_rows');
            if ($search_content) {
                $count = $this
                    ->where('shop_name', 'like', '%' . $search_content . '%')
                    ->whereOr('shop_address', 'like', '%' . $search_content . '%')
                    ->whereOr('shop_leader', 'like', '%' . $search_content . '%')
                    ->whereOr('phone', 'like', '%' . $search_content . '%')
                    ->count();
                $list = $this
                    ->where('shop_name', 'like', '%' . $search_content . '%')
                    ->whereOr('shop_address', 'like', '%' . $search_content . '%')
                    ->whereOr('shop_leader', 'like', '%' . $search_content . '%')
                    ->whereOr('phone', 'like', '%' . $search_content . '%')
                    ->field('shop_id, company_id,shop_name, shop_address, shop_leader, phone, pay_flag')
                    ->limit(($page - 1) * $limit, $limit)
                    ->order('shop_id', 'desc')
                    ->select();
            } else {
                $list = $this
                    ->field('shop_id, company_id,shop_name, shop_address, shop_leader, phone, pay_flag')
                    ->limit(($page - 1) * $limit, $limit)
                    ->order('shop_id', 'desc')
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

        if ($info = $this->where('shop_id', $id)->find()->data) {
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
            $insert_data = [
                'shop_name' => input('shop_name'),
                'company_id' => input('company_id'),
                'shop_address' => input('shop_address'),
                'shop_leader' => input('shop_leader'),
                'phone' => input('phone')
            ];
            if (input('shop_id')) {
                $update_data = array_merge($insert_data, ['shop_id' => input('shop_id')]);
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

    public function delete_info($id)
    {
        if ($id) {
            $info = $this->where('shop_id', $id)->count();
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
}