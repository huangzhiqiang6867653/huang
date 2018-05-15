<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/5/15
 * Time: 下午12:07
 */

namespace app\system\controller;
use app\common\CommonController;
use app\system\model\BusinessUser;
use think\Session;

class Index extends CommonController
{
    /**
     * @return \think\response\View
     * 系统首页
     */
    public function index()
    {
        $user = new BusinessUser();
        $system_config = [
            //配置信息
            'system_name'  => config('system.system_name'),
            'system_footer'  => config('system.system_footer'),
            'user_info' => Session::get('user_info'),
            'menu_list' => $user->get_user_menu(),
        ];

        return view('index', $system_config);

    }
}