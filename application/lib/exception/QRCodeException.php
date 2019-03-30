<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2018/12/16
 * Time: 15:10
 */

namespace app\lib\exception;


class QRCodeException extends BaseException
{
    public $code = 400;
    public $message = '二维码没有内容';
    public $errorCode = 70000;
}