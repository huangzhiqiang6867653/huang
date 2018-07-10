<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/7/8
 * Time: 上午9:52
 */

namespace app\system\controller;

use app\common\CommonController;
use app\system\model\Customer as PublicModel;

class Customer extends CommonController
{
    /**
     * @return \think\response\View
     * 管理
     */
    public function index()
    {
        return view("index");
    }

    /**
     * @param int $page
     * @param $limit
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 列表
     *
     */
    public function listPage($page = 1, $limit)
    {
        $model = new PublicModel();
        $model->get_list($page, $limit, request()->get('search_content'));
    }

    /**
     * @param string $id
     * @param string $type
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 表单页面
     */
    public function form($id = '', $type = 'add')
    {

        $message = [
            'form_type' => $type,
            'rootPath' => request()->domain() . request()->root() . '/system/customer/aud'
        ];
        if ($id) {
            $model = new PublicModel();
            $info = $model->get_info($id);
            $message = array_merge($message, $info);
        }
        return view('form', $message);
    }

    /**
     * 添加修改方法
     */
    public function aud()
    {
        $model = new PublicModel();
        return $model->aud();

    }

    public function delete($id)
    {
        $model = new PublicModel();
        return $model->delete_info($id);
    }

    public function add_record($id)
    {
        $model = new PublicModel();
        $min_date = $model->get_max_date_record($id);
        $data = [
            'customer_id' => $id,
            'rootPath' => request()->domain() . request()->root() . '/system/customer/record_aud',
            'record_list' => $model->get_customer_record_list($id),
            'min_date' => $min_date?$min_date['track_time']:''
        ];
        return view("add_record", $data);
    }

    public function view_record($id)
    {
        return view("view_record", ['company_id' => $id]);
    }

    public function record_aud()
    {
        $model = new PublicModel();
        return $model->record_aud();
    }
}