<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2018/11/28
 * Time: 23:18
 */

// +----------------------------------------------------------------------
// | 项目自定义配置
// +----------------------------------------------------------------------

return [
    // 文件上传到本地还是OSS local 本地/ oss阿里云OSS
    'file_upload_bucket' => 'local',

    // 静态文件目录
    'static'=> __DIR__.'/../../public/static/',

    // 图片地址前缀
    'image_prefix'  => 'http://base.com/static/image/',
    'static_image' => __DIR__.'/../../public/static/image/',

    // 二维码存储目录
    'qrcode_prefix' => 'http://base.com/static/qrcode/',
    'static_qrcode' => __DIR__.'/../../public/static/qrcode/',

    // excel
    'excel_prefix' => 'http://base.com/static/excel/',
    'static_excel' => __DIR__.'/../../public/static/excel/',

    // 字体目录
    'static_font' => __DIR__.'/../../public/static/font/',
];

// 获取 config('program.img_prefix')