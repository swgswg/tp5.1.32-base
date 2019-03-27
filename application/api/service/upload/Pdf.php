<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2019/1/10
 * Time: 19:39
 */

namespace app\api\service\upload;


class Pdf extends BaseUpload
{
    /**
     * 上传文件类型
     * @var string
     */
    protected $fileType = 'pdf';

    /**
     * 允许上传的最大文件大小
     * 1 * 1024 * 1024 = 1M
     * @var int
     */
    protected $maxSize = 1048576;

    /**
     * 文件后缀
     * @var array
     */
    protected $fileExtTypes = ['pdf'];
}