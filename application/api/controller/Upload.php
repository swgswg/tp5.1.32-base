<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2019/3/27
 * Time: 15:04
 */

namespace app\api\controller;


use app\api\service\Excel;
use app\api\service\qrcode\QRcode;
use app\api\service\upload\ClassArr;
use app\lib\exception\UploadException;
use think\facade\Request;

class Upload extends BaseController
{
    /**
     * 上传文件
     * @return \think\response\Json
     * @throws UploadException
     */
    public function upload()
    {
        $uploadObj = $this->getUploadObj();
        $fileName = $uploadObj->upload();
        // $prefix = config('program.img_prefix');
        $data = [
            'url' => $fileName
        ];
        return $this->out('上传', $data);
    }


    /**
     * 获取表格数据
     * @return \think\response\Json
     * @throws UploadException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function getExcelData()
    {
        $uploadObj = $this->getUploadObj();
        $tmpPath = $uploadObj->getTmpName();
        $ext = $uploadObj->getExt();
        $head = [];
        $data = Excel::getInstance()->getExcelData($head, $tmpPath, $ext);
        return $this->out('获取表格数据', $data);
    }


    public function qrcode()
    {
        $text = Request::post('text');
        $data = QRcode::getInstance()->qrcode($text);
        return $this->out('生成二维码', $data);
    }


    private function getUploadObj()
    {
        $files = Request::file();
        $types = array_keys($files);
        $type = $types[0];
        if(empty($type)){
            throw new UploadException([
                'code' => 400,
                'message' => '上传文件不合法',
                'errorCode' => 20003
            ]);
        }

        // php 反射机制
        $uploadObj = ClassArr::getInstance()->initClass($type, [$type]);
        return $uploadObj;
    }




}