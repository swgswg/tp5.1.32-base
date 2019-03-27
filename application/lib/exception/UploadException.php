<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2019/3/27
 * Time: 13:01
 */

namespace app\lib\exception;


class UploadException extends BaseException
{
    public $code = 400;
    public $message = '上传文件失败';
    public $errorCode = 20000;
}