<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2019/1/3
 * Time: 10:39
 */

namespace app\api\controller;


use think\Controller;

class BaseController extends Controller
{
    protected static function out($message, $data = '', $flag = false)
    {
        $msg = $message . '成功';
        if($flag){
            $msg = $message;
        }
        if($data !== '' ){
            $result = [
                'message' => $msg,
                'state' => 1,
                'data' => $data,
                'error_code' => 'request:ok',
            ];
        } else {
            $result = [
                'message' => $msg,
                'state' => 1,
                'error_code' => 'request:ok',
            ];
        }
        return json($result);
    }
}