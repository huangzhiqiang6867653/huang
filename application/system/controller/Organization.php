<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/5/16
 * Time: 下午3:06
 */

namespace app\system\controller;
use app\common\CommonController;

class Organization extends CommonController
{
    /**
     * @return \think\response\View
     * 组织管理
     */
    public function index()
    {
        return view('index');

    }
}