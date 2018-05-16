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

class User extends CommonController
{
    /**
     * @return \think\response\View
     * 用户管理
     */
    public function index()
    {
        $user = new BusinessUser();
        $user_list = $user->all();
        return view('index');

    }
}