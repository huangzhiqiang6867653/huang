<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/7/7
 * Time: 下午5:08
 */

namespace app\system\model;

use app\common\CommonModel;

class Company extends CommonModel
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
                    ->where('company_name', 'like', '%' . $search_content . '%')
                    ->whereOr('address', 'like', '%' . $search_content . '%')
                    ->whereOr('contacts', 'like', '%' . $search_content . '%')
                    ->whereOr('contact_number', 'like', '%' . $search_content . '%')
                    ->count();
                $list = $this
                    ->where('company_name', 'like', '%' . $search_content . '%')
                    ->whereOr('address', 'like', '%' . $search_content . '%')
                    ->whereOr('contacts', 'like', '%' . $search_content . '%')
                    ->whereOr('contact_number', 'like', '%' . $search_content . '%')
                    ->field('company_id,company_name, address, contacts, contact_number, pay_flag')
                    ->limit(($page - 1) * $limit, $limit)
                    ->order('company_id', 'desc')
                    ->select();
            } else {
                $list = $this
                    ->field('company_id,company_name, address, contacts, contact_number, pay_flag')
                    ->limit(($page - 1) * $limit, $limit)
                    ->order('company_id', 'desc')
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

        if ($info = $this->where('company_id', $id)->find()->data) {
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
                'company_name' => input('company_name'),
                'address' => input('address'),
                'contacts' => input('contacts'),
                'contact_number' => input('contact_number')
            ];
            if (input('company_id')) {
                $update_data = array_merge($insert_data, ['company_id' => input('company_id')]);
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
            $info = $this->where('company_id', $id)->count();
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