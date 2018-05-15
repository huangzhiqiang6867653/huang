<?php
/**
 * Created by PhpStorm.
 * User: huangzhiqiang
 * Date: 2018/5/11
 * Time: 下午8:45
 */

namespace app\index\model;
use think\Model;
use traits\model\SoftDelete;


class Test extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_flag';

    /*新增*/
    public static function inserts($data)
    {
        $check = Test::create($data);
        if ($check) {
            return true;
        }else{
            return false;
        }
    }

    /*数据查询*/
    public static function lists(){
        $lists=Test::where([])->order('id asc')->paginate(5);
        // $lists=Students::where([])->order('id asc')->select();
        return $lists;
    }


    /*删除数据*/
    public static function dels($id){
        $info=Test::where(["id"=>$id])->delete();
        if ($info) {
            return true;
        }else{
            return false;
        }
    }

    /*查询一条数据*/
    public static function finds($id){
        $info=Test::where(["id"=>$id])->find();
        return $info;
    }

    /*修改数据*/
    public static function updatemsgs($data,$id){
        // dump($data);
        $info=Test::where(["id"=>$id])->update($data);
        if ($info) {
            return true;
        }
    }


}