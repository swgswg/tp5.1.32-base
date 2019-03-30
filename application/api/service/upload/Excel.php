<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2019/3/30
 * Time: 11:58
 */

namespace app\api\service\upload;


class Excel extends BaseUpload
{
    /**
     * 上传文件类型
     * @var string
     */
    protected $fileType = 'excel';

    /**
     * 允许上传的最大文件大小
     * 5 * 1024 * 1024 = 5M
     * @var int
     */
    protected $maxSize = 5242880;

    /**
     * 文件后缀
     * @var array
     */
    protected $fileExtTypes = ['xls', 'xlsx'];
}