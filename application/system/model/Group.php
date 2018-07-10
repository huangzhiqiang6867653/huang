<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/7/8
 * Time: 下午10:47
 */

namespace app\system\model;
use app\common\CommonModel;
use traits\model\SoftDelete;
use think\Session;

class Group extends CommonModel
{
    //软删除
    use SoftDelete;
    protected $deleteTime = 'delete_flag';
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
                    ->where('group_name', 'like', '%' . $search_content . '%')
                    ->whereOr('remark', 'like', '%' . $search_content . '%')
                    ->count();
                $list = $this
                    ->where('group_name', 'like', '%' . $search_content . '%')
                    ->whereOr('remark', 'like', '%' . $search_content . '%')
                    ->field('group_id, company_id, shop_id, group_name, remark')
                    ->limit(($page - 1) * $limit, $limit)
                    ->order('add_time', 'desc')
                    ->select();
            } else {
                $list = $this
                    ->field('group_id, company_id, shop_id, group_name, remark')
                    ->limit(($page - 1) * $limit, $limit)
                    ->order('add_time', 'desc')
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

        if ($info = $this->where('group_id', $id)->find()->data) {
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
                'group_name' => input('group_name'),
                'remark' => input('remark'),
                'add_time' => date('Y-m-d H:i:s', time()),
                'add_user' => Session::get('user_info')->user_id
            ];
            if (input('group_id')) {
                $update_data = array_merge($insert_data, ['group_id' => input('group_id')]);
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
            $info = $this->where('group_id', $id)->count();
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