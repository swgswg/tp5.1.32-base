<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2019/1/3
 * Time: 10:40
 */

namespace app\api\model;


use think\Model;

class BaseModel extends Model
{
    // 设置完整图片路径 ($value, $data)
    protected function prefixImgUrl($value)
    {
        return config('program.img_prefix').$value;
    }
}