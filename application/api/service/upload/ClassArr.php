<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2019/1/10
 * Time: 19:57
 */

namespace app\api\service\upload;


use app\api\com\Singleton;
use app\lib\exception\UploadException;

class ClassArr
{
    use Singleton;

    /**
     * 定义上传文件类
     * @return array
     */
    private $uploadClassStats = [
        'image' => Image::class,
        'pdf'   => Pdf::class,
    ];


    private function __construct()
    {}


    /**
     * 实例化对象
     * @param $type
     * @param array $params
     * @param bool $needInstance
     * @return mixed|object
     * @throws UploadException
     * @throws \ReflectionException
     */
    public function initClass($type, $params = [], $needInstance = true)
    {
        if(!isset($this->uploadClassStats[$type])){
            throw new UploadException([
                'code' => 400,
                'message' => '上传文件类型错误',
                'errorCode' => 20005
            ]);
        }
        $className = $this->uploadClassStats[$type];
        $class = $needInstance ? (new \ReflectionClass($className)) -> newInstanceArgs($params) : $className;
        return $class;
    }
}