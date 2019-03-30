<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2019/3/27
 * Time: 10:36
 */

namespace app\api\com;


class StringUtil extends BaseCom
{
    /**
     *  随机字符串
     * @param integer $length 字符串长度
     * @return null|string
     */
    public function getRandChars($length)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;
        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[rand(0, $max)];
        }
        return $str;
    }


    /**
     * 随机文件名
     * @return string
     */
    public function randFileName()
    {
        $fileName = date('YmdHis').rand(100000,999999);
        return $fileName;
    }

}