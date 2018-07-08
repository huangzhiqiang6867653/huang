<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/7/8
 * Time: 上午11:13
 */

namespace app\system\controller;
use app\common\CommonController;
use app\system\model\Shop as CompanyModel;

class Shop extends CommonController
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
     */
    public function listPage($page = 1, $limit)
    {
        $company = new CompanyModel();
        $company->get_list($page, $limit, request()->get('search_content'));
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
            'rootPath' => request()->domain() . request()->root() . '/system/shop/aud'
        ];
        if ($id) {
            $company = new CompanyModel();
            $info = $company->get_info($id);
            $message = array_merge($message, $info);
        }
        return view('form', $message);
    }

    /**
     * 添加修改方法
     */
    public function aud()
    {
        $company = new CompanyModel();
        return $company->aud();

    }

    public function delete($id)
    {
        $company = new CompanyModel();
        return $company->delete_info($id);
    }
}