<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/5/16
 * Time: 下午2:53
 */

namespace app\system\controller;
use app\common\CommonController;

class Role extends CommonController
{
    /**
     * @return \think\response\View
     * 角色权限管理
     */
    public function index()
    {
        return view('index');

    }
}