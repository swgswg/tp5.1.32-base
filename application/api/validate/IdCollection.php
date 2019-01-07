<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2019/1/3
 * Time: 11:10
 */

namespace app\api\validate;


class IdCollection extends BaseValidate
{
    // 千万不要在require | checkIDS中加空格
    // 源码中是没有去处多余空格的判断的
    // 这将导致验证不执行
    protected $rule = [
        'ids' => 'require|checkIDs'
    ];

    protected $message = [
        'ids' => 'ids参数必须为以逗号分隔的多个正整数'
    ];

    protected function checkIDs($value)
    {
        $values = explode(',', $value);
        if (empty($values)) {
            return false;
        }
        foreach ($values as $id) {
            if (!$this->isPositiveInteger($id)) {
                // 必须是正整数
                return false;
            }
        }
        return true;
    }

    protected function checkIDs1($value, $rule, $data)
    {
        $result = true;
        $values = explode(',', $value);
        if (empty($values)) {
            $result = false;
        }
        array_walk($values, function ($id) use (&$result) {
            if (!$this->isPositiveInteger($id)) {
                // 必须是正整数
                $result = false;
            }
        });
        return $result;
    }

}