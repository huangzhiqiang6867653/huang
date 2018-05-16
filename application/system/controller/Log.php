<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/5/16
 * Time: 下午3:07
 */

namespace app\system\controller;
use app\common\CommonController;

class Log extends CommonController
{
    /**
     * @return \think\response\View
     * 日志管理
     */
    public function index()
    {
        return view('index');

    }
}