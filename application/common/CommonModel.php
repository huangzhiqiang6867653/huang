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
    //列表
    protected static $LIST_SUCCESS_CODE = 0;
    protected static $LIST_FAIL_CODE = -1;
    //其他
    protected static $OPERATION_SUCCESS_CODE = 200;
    protected static $OPERATION_FAIL_CODE = 204;
    protected static $OPERATION_EXCEPTION_CODE = 203;

    protected static $OPERATION_SUCCESS_MESSAGE = '操作成功';
    protected static $OPERATION_FAIL_MESSAGE = '操作失败';
    protected static $OPERATION_EXCEPTION_MESSAGE = '操作异常';

    protected $type = [
        'delete_flag'    =>  'integer',
        'create_time'     =>  'datetime',
        'update_time'  =>  'datetime'
    ];

    /**
     * @param $count
     * @param $list
     * 成功返回数据处理
     */
    public function list_success_return($count, $list) {
        echo json_encode((object)[
            'code' => self::$LIST_SUCCESS_CODE,
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
            'code' => self::$LIST_FAIL_CODE,
            'count' => 0,
            'data' => [],
            'msg' => $e]);
    }

    /**
     * @param $data
     * 成功处理
     */
    public function json_success($data){
        echo json_encode((object)[
            'code' => self::$OPERATION_SUCCESS_CODE,
            'result' => $data,
            'msg' => self::$OPERATION_SUCCESS_MESSAGE]);
    }

    /**
     * @param $data
     * 失败处理
     */
    public function json_fail($data){
        echo json_encode((object)[
            'code' => self::$OPERATION_FAIL_CODE,
            'result' => $data,
            'msg' => self::$OPERATION_FAIL_MESSAGE]);
    }

    /**
     * @param $data
     * 异常处理
     */
    public function json_exception($data){
        echo json_encode((object)[
            'code' => self::$OPERATION_EXCEPTION_CODE,
            'result' => $data,
            'msg' => self::$OPERATION_EXCEPTION_MESSAGE]);
    }
}