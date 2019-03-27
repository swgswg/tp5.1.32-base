<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2019/1/10
 * Time: 17:50
 */

namespace app\api\service\upload;


class Image extends BaseUpload
{
    /**
     * 上传文件类型
     * @var string
     */
    protected $fileType = 'image';

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
    protected $fileExtTypes = ['jpg', 'jpeg', 'png', 'gif'];

}