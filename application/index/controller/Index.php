<?php
namespace app\index\controller;
use app\index\model\Test;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $this->redirect('system/index/index');
    }
}
