<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/5/15
 * Time: 下午12:08
 */

namespace app\system\controller;
use app\common\CommonController;
use app\system\model\BusinessUser;
use think\Exception;

class User extends CommonController
{
    /**
     * @return \think\response\View
     * 用户管理
     */
    public function index()
    {
        return view('index');
    }

    /**
     * @param int $page
     * @param $limit
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 用户列表
     */
    public function user_list($page = 1, $limit) {
        $user = new BusinessUser();
        $user->get_user_list($page, $limit);
    }

    public function to_user_form($user_id = '', $type = 'add'){

        $message = [
            'form_type' => $type
        ];
        if($user_id) {
            $user = new BusinessUser();
            $user_info = $user->get_user_info($user_id);
            $message = array_merge($message, $user_info);
        }
        return view('form', $message);
    }

    public function delete_user_info($user_id = '') {
        $user = new BusinessUser();
        $user->delete_user_info($user_id);
    }
}