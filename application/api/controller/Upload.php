<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2019/3/27
 * Time: 15:04
 */

namespace app\api\controller;


use app\api\service\upload\ClassArr;
use app\lib\exception\UploadException;
use think\facade\Request;

class Upload extends BaseController
{
    public function upload()
    {
        $files = Request::file();
        $types = array_keys($files);
        $type = $types[0];
        if(empty($type)){
            throw new UploadException([
                'code' => 400,
                'message' => '上传文件不合法',
                'errorCode' => 20003
            ]);
        }

        // php 反射机制
        $uploadObj = ClassArr::getInstance()->initClass($type, [$type]);
        $fileName = $uploadObj->upload();

        // $prefix = config('program.img_prefix');
        $data = [
            'url' => $fileName
        ];
        return $this->out('上传', $data);
    }
}