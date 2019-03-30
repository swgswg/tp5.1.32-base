<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2019/3/30
 * Time: 10:32
 */

namespace app\api\service\upload;


use app\api\com\Singleton;
use app\lib\exception\UploadException;
use OSS\OssService;

class MoveUploadFile
{
    // 文件名
    private $fileType;
    private $fileName;
    private $tmpPath;
    private $fileUploadBucket;

    use Singleton;

    private function __construct($fileType, $fileName, $tmpPath)
    {
        $this->fileType = $fileType;
        $this->fileName = $fileName;
        $this->tmpPath = $tmpPath;
        $this->fileUploadBucket = config('program.file_upload_bucket');
    }


    /**
     * 移动
     * @return array|mixed|null
     * @throws UploadException
     * @throws \OSS\Core\OssException
     */
    public function moveTo()
    {
        if($this->fileUploadBucket == 'oss'){
            $url = $this->moveToOss($this->fileName, $this->tmpPath);
        } else {
            $filePath = $this->getFilePath($this->fileType, $this->fileName);
            $url = $this->moveToLocal($filePath, $this->tmpPath);
        }
        return $url;
    }


    /**
     * 获取新文件完成路径(带文件名)
     * @param string $fileType  文件类型
     * @param string $fileName  文件要保存的名称
     * @return string 文件名
     */
    protected function getFilePath($fileType, $fileName)
    {
        $savePath = config('program.static') . $fileType . '/';
        if(!is_dir($savePath)){
            mkdir($savePath, 0777, true);
        }
        $url = $savePath . $fileName;
        return $url;
    }


    /**
     * 上传到本地
     * @param $url
     * @param $tmpPath
     * @return mixed
     * @throws UploadException
     */
    protected function moveToLocal($url, $tmpPath)
    {
        $res = move_uploaded_file($tmpPath, $url);
        if(!$res){
            throw new UploadException([
                'code' => 400,
                'message'=> '上传文件失败',
                'errorCode'=> 20006
            ]);
        }
        return $url;
    }


    /**
     * 上传文件到阿里云
     * @param string $fileName  想要保存文件的名称
     * @param string $tmpPath   上传的文件在服务器的临时文件地址
     * @return array|null 返回阿里云的文件全路径/错误信息
     * @throws \OSS\Core\OssException
     */
    protected function moveToOss($fileName, $tmpPath)
    {
        $oss  = (new OssService())->ossUpload($fileName, $tmpPath);
        if(array_key_exists('error', $oss)){
            return $oss;
        } else {
            return $oss['info']['url'];
        }
    }

}