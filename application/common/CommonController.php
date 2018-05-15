<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/5/15
 * Time: 下午1:03
 */

namespace app\common;


use think\Controller;
use think\Request;
use think\Session;

class CommonController extends Controller
{
    public function _initialize()
    {
        //获取请求路径的白名单
        $white_list =  config('white_list');
        //用户登录校验，如果session过期则重新登录
        if(!Session::get('user_info') && !in_array(Request::instance()->path(),$white_list)) {;
            $this->success('会话失效，请重新登录～', 'system/login/index');
        }else{
        }
    }
}