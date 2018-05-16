<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/5/16
 * Time: 下午3:16
 */

namespace app\system\controller;
use app\common\CommonController;

class Dictionary extends CommonController
{
    /**
     * @return \think\response\View
     *  字典管理
     */
    public function index()
    {
        return view('index');

    }

}