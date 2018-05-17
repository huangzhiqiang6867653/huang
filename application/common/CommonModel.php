<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/5/17
 * Time: 下午7:20
 */

namespace app\common;


use think\Model;

class CommonModel extends Model
{
    /**
     * @param $count
     * @param $list
     * 成功返回数据处理
     */
    public function list_success_return($count, $list) {
        echo json_encode((object)[
            'code' => 0,
            'count' => $count,
            'data' => $list,
            'msg' => '']);
    }

    /**
     * @param string $e
     * 失败返回数据处理
     */
    public function list_error_return($e = ''){
        echo json_encode((object)[
            'code' => -1,
            'count' => 0,
            'data' => [],
            'msg' => $e]);
    }
}