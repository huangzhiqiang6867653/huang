<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/5/16
 * Time: 下午2:51
 */

namespace app\system\controller;
use app\common\CommonController;


class Group extends CommonController
{
    /**
     * @return \think\response\View
     * 用户组管理
     */
    public function index()
    {
        return view('index');

    }
}