<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/5/16
 * Time: 下午2:57
 */

namespace app\system\controller;
use app\common\CommonController;

class Functions extends CommonController
{
    /**
     * @return \think\response\View
     *  功能管理
     */
    public function index()
    {
        return view('index');

    }
}