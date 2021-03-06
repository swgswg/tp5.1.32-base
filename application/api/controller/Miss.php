<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2018/12/3
 * Time: 16:58
 */

namespace app\api\controller;

use app\lib\exception\MissException;

/**
 * MISS路由，当全部路由没有匹配到时
 * 将返回资源未找到的信息
 */
class Miss extends BaseController
{
    public function miss()
    {
        throw new MissException();
    }
}