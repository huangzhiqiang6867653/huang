<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/7/7
 * Time: 下午9:10
 */

namespace app\system\controller;

use app\common\CommonController;
use app\system\model\User as PublicModel;
use think\Session;

class Sales extends CommonController
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
        $model = new PublicModel();
        $message = [
            'form_type' => $type,
            'rootPath' => request()->domain() . request()->root() . '/system/sales/aud',
            'login_user_type' => Session::get('user_info')->classify
        ];
        if ($user_info = Session::get('user_info')) {
            if ($user_info->classify == 'admin') {
                $company_list = $model->get_company_list();
                $message = array_merge($message, ['company_list' => $company_list]);
            } elseif ($user_info->classify == 'company') {
                $shop_list = $model->get_shop_list($user_info->company_id);
                $message = array_merge($message, ['shop_list' => $shop_list]);
            }
        }
        if ($id) {
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

    public function get_shop_list($company_id)
    {
        $model = new PublicModel();
        return $model->get_shop_list_ajax($company_id);
    }
}