<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2019/3/27
 * Time: 12:58
 */

namespace app\api\service\upload;

use app\api\com\StringUtil;
use app\lib\exception\UploadException;
use OSS\OssService;
use think\facade\Request;

class BaseUpload
{
    protected $fileInfo;

    /**
     * 上传文件类型
     * @var string
     */
    protected $fileType;

    /**
     * 允许上传的最大文件大小
     * @var int
     */
    protected $maxSize;

    /**
     * 文件后缀
     * @var array
     */
    protected $fileExtTypes;

    /**
     * 上传文件的 key
     * @var
     */
    protected $type;

    /**
     * 文件大小
     * @var
     */
    protected $size;

    /**
     * 文件名称
     * @var
     */
    protected $fileName;

    /**
     * 文件类型
     * @var
     */
    protected $clientMediaType;

    /**
     * 临时路径
     * @var
     */
    protected $tmpPath;

    public function __construct($type)
    {
        if(empty($type)){
            $files = Request::file();
            $types = array_keys($files);
            $type = $types[0];
            $this->type = $type;
        } else {
            $this->type = $type;
        }
    }


    /**
     * 上传文件
     * @return bool|string
     * @throws \Exception
     */
    public function upload()
    {
        // 上传类型和定义类型不一样
        if($this->type != $this->fileType){
            throw new UploadException([
                'code' => 400,
                'message' => '上传类型和定义类型不一样',
                'errorCode' => 20002
            ]);
        }
        $this->getFileInfo();
        $this->needChecks();
        $this->fileName = $this->getFileName();
        $this->tmpPath = $this->getTmpName();
        $this->moveTo($this->fileType, $this->fileName, $this->tmpPath);
        return $this->fileName;
    }


    /**
     * 需要做的 检测
     * @throws \Exception
     */
    private function needChecks()
    {
        // 检测大小
        $this->checkSize();
        // 检测类型
        $this->checkMediaType();
    }


    /**
     * 检测文件大小
     * @throws \Exception
     */
    protected function checkSize()
    {
        $this->size = $this->getSize();
        if(empty($this->size)){
            throw new UploadException([
                'code' => 400,
                'message' => '上传文件不合法',
                'errorCode' => 20003
            ]);
        }
        if($this->size > $this->maxSize){
            throw new UploadException([
                'code' => 400,
                'message' => '上传文件过大',
                'errorCode' => 20004
            ]);
        }
    }


    /**
     * 检测文件类型
     * @throws \Exception
     */
    protected function checkMediaType()
    {
        $this->clientMediaType = $this->getExt();
        if(empty($this->clientMediaType)){
            throw new UploadException([
                'code' => 400,
                'message' => '上传文件类型错误',
                'errorCode' => 20005
            ]);
        }
        if(!in_array($this->clientMediaType, $this->fileExtTypes)){
            throw new UploadException([
                'code' => 400,
                'message' => '上传文件类型错误',
                'errorCode' => 20005
            ]);
        }
    }


    /**
     * 移动临时文件到指定目录 保存文件
     * @param string $type 文件类型
     * @param string $fileName 文件名称
     * @param string $tmpPath 文件临时路径
     * @throws UploadException
     */
    protected function moveTo($type, $fileName, $tmpPath)
    {
        $res = MoveUploadFile::getInstance($type, $fileName, $tmpPath)->moveTo();
        if(!$res){
            throw new UploadException([
                'code' => 400,
                'message'=> '上传文件失败',
                'errorCode'=> 20006
            ]);
        }
    }





    /**
     * 获取文件信息
     * @throws UploadException
     */
    protected function getFileInfo()
    {
        $file = Request::file($this->fileType);
        if(empty($file)){
            throw new UploadException([
                'code' => 400,
                'message' => '没有文件',
                'errorCode' => 20001
            ]);
        }
        $this->fileInfo = $file->getInfo();

        //  [
        // "name"=> string(14) "ls-480x762.png"
        // "type"=> string(9) "image/png"
        // "tmp_name"=> string(22) "C:\Windows\phpF8DB.tmp"
        // "error"=> int(0)
        // "size"=> int(237615)
        // ]
        // ["type"]=> string(18) "application/msword"  doc
        // ["type"]=> string(15) "application/pdf"   pdf
        // ["type"]=> string(71) "application/vnd.openxmlformats-officedocument.wordprocessingml.document" docx
        // ["type"]=> string(65) "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" xlsx

    }


    /**
     * 获取文件大小
     * @return mixed
     */
    protected function getSize()
    {
        //获取表格的大小，限制上传表格的大小5M
        return $this->fileInfo['size'];
    }

    /**
     * 获取文件后缀
     * @return bool|string
     */
    protected function getExt()
    {
        $ext = substr($this->fileInfo['name'], strrpos($this->fileInfo['name'], '.')+1);
        return $ext;
    }



    /**
     * 获取文件在服务器的临时位置
     * @return mixed
     */
    protected function getTmpName()
    {
        return $this->fileInfo['tmp_name'];
    }


    /**
     * 获取文件MD5值
     * @return string
     */
    protected function getFileMd5()
    {
        $md5 = md5_file($this->fileInfo['tmp_name']);
        return $md5;
    }

    /**
     * 获取文件名
     * @param bool $useOriginal 是否使用源文件名
     * @return string
     */
    protected function getFileName($useOriginal = false)
    {
        $originalName = $this->fileInfo['name'];
        // 上传的文件名是否使用原来的文件名字
        if($useOriginal){
            $fileName = $originalName;
        } else {
            $randName = StringUtil::getInstance()->randFileName();
            $ext = $this->getExt($this->fileInfo);
            $fileName =  $randName . '.' . $ext;
        }
        return $fileName;
    }

}