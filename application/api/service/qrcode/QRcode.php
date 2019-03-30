<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2019/3/30
 * Time: 11:19
 */

namespace app\api\service\qrcode;

use app\api\com\Singleton;
use app\api\com\StringUtil;
use app\lib\exception\QRCodeException;
use PHPQRCode\QRcode as PhpQRcode;

class QRcode
{
    use Singleton;

    private function __construct()
    {}

    public function qrcode($text = '请输入内容', $size = 6, $filename = '')
    {
        // 二维码的内容
        // $text = ;
        if(empty($text)){
            throw new QRCodeException();
        }

        //二维码导出的储存地址
        if(!$filename){
            $filename = StringUtil::getInstance()->randFileName();
        }
        $savePath = config('program.static_qrcode');
        if(!is_dir($savePath)){
            mkdir($savePath, 0777, true);
        }
        $filename = $filename .".png";
        $outfile = $savePath. $filename;
        //二维码的大小
        // $size = 6;
        //调用方法成功后,会在相应文件夹下生成二维码文件
        PhpQRcode::png($text, $outfile, $size);

        return $filename;
    }
}