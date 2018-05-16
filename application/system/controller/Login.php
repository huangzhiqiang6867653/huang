<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/5/15
 * Time: 下午12:07
 */

namespace app\system\controller;
use think\Session;
use app\common\CommonController;
use app\system\model\BusinessUser;

class Login extends CommonController
{
    /**
     * @return \think\response\View
     * 登录页面
     */
    public function index(){
        if(Session::has('user_info')){ //校验登录状态，已登录重定向到首页，未登录进行登录操作
            $this->redirect('system/index/index');
        }
        $system_config = [
            'system_name'  => config('system.system_name')
        ];
        return view('login', array_merge(['error_msg'=>''],$system_config));
    }

    /**
     * @param string $user_name
     * @param string $password
     * 登录校验
     */
    public function do_login($user_name = '', $password = '') {
        $user = new BusinessUser();
        $check_result = $user->user_check($user_name, $password);
        if(array_column($check_result,'flag')){
            $this->error(array_column($check_result,'msg'));
        }else {
            $this->redirect('system/index/index');
        }

    }

    /**
     * 退出
     */
    public function do_logout() {
        Session::clear(config('session.prefix'));
        $this->redirect('system/login/index');
    }
}