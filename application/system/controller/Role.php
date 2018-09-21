<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/5/16
 * Time: 下午2:53
 */

namespace app\system\controller;
use app\common\CommonController;
use app\system\model\BusinessRole as PublicModel;
class Role extends CommonController
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
        $publicModel = new PublicModel();
        $publicModel->get_list($page, $limit, request()->get('search_content'));
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
            'rootPath' => request()->domain() . request()->root() . '/system/role/aud'
        ];
        if ($id) {
            $publicModel = new PublicModel();
            $info = $publicModel->get_info($id);
            $message = array_merge($message, $info);
        }
        return view('form', $message);
    }

    /**
     * 添加修改方法
     */
    public function aud()
    {
        $publicModel = new PublicModel();
        return $publicModel->aud();

    }

    public function delete($id)
    {
        $publicModel = new PublicModel();
        return $publicModel->delete_info($id);
    }
}