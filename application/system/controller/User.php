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
     * 用户列表
     */
    public function user_list($page = 1, $limit) {
        $user = new BusinessUser();
        $user->get_user_list($page, $limit);
    }
}