<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2019/3/30
 * Time: 11:41
 */

namespace app\lib\exception;


class ExcelException extends BaseException
{
    public $code = 400;
    public $message = 'excel操作错误';
    public $errorCode = 10003;
}