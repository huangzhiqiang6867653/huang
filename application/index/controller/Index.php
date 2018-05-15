<?php
namespace app\index\controller;
use app\index\model\Test;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        //1、获取系统配置参数
        $system_config = [
            'system_name'  => config('system.system_name'),
            'system_footer'  => config('system.system_footer'),
        ];
        //2、获取登录用户基本信息

        //3、获取用户权限数据

        return view('index', array_merge([],$system_config));
    }
    public function hello($name = 'php') {
        return 'hello '. $name;
    }
}
