<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2018/12/13
 * Time: 15:52
 */

namespace app\api\validate;


use think\Validate;
use think\facade\Request;
use app\lib\exception\ParameterException;

class BaseValidate extends Validate
{
    /**
     * 验证直接接受的数据
     * @return bool
     * @throws ParameterException]
     */
    public function goCheck()
    {
        $params = Request::post();
        return $this->checkParams($params);
    }

    /**
     * 验证处理的数据
     * @param $params
     * @return bool
     * @throws ParameterException
     */
    public function checkParams($params)
    {
        $res = $this->batch()->check($params);
        if(!$res){
            $err = $this->getError();
            if(is_array($err)){
                $err = implode(',',$err);
            }
            $e = new ParameterException([
                'message' => $err
            ]);
            // $e->message = $this->getError();
            throw $e;
        } else {
            return true;
        }
    }


    /**
     *  必须是正整数
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool|string
     */
    protected function isPositiveInteger($value, $rule = '', $data = '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        return $field . '必须是正整数';
    }


    /**
     *  不能是空
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool|string
     */
    protected function isNotEmpty($value, $rule = '', $data = '', $field = '')
    {
        if (empty($value)) {
            return $field . '不允许为空';
        } else {
            return true;
        }
    }


    /**
     * 手机号的验证规则
     * 没有使用TP的正则验证，集中在一处方便以后修改
     * 不推荐使用正则，因为复用性太差
     * @param $value
     * @return bool|string
     */
    protected function isMobile($value)
    {
        $rule = '/^1(3|4|5|7|8)[0-9]\d{8}$^/';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return '手机号格式不正确';
        }
    }


    /**
     * 金额验证规则 (整数位最多八位,小数为最多为两位,可以无小数位)
     * @param $value
     * @return bool|string
     */
    protected function money($value)
    {
        $rule = '/^(([0-9]|([1-9][0-9]{0,7}))((\.[0-9]{1,2})?))$/';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return '金额格式不正确';
        }
    }


    /**
     *  检查图片文件名后缀是否允许
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool|string
     */
    protected function checkImageType($value, $rule = '', $data = '', $field = '')
    {
        // 获取照片的后缀
        $ext = strrchr($value, '.');
        if(!$ext){
            return '文件格式不正确';
        }
        $type = substr($ext, 1);
        $typeArray = ['png', 'jpeg', 'jpg'];
        if(in_array($type, $typeArray)){
            return true;
        } else {
            return '文件格式不正确';
        }
    }


    /**
     * 验证数组
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool|string
     */
    protected function isArr($value, $rule = '', $data = '', $field = '')
    {
        $val = json_decode($value, true);
        if(is_array($val) && !empty($val)){
            return true;
        } else {
            return $field.'是数组且不能为空';
        }
    }


    /**
     * 路由正则
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool|string
     */
    protected function routeReg($value, $rule = '', $data = '', $field = '')
    {
        $rule = '/^(\/\w+)+$/';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return $field.'格式不正确';
        }
    }


    /**
     * 判断是不是合法的文件
     * @param $value
     * @return bool|string
     */
    protected function isUploadedFile($value)
    {
        if(is_uploaded_file($value)){
            return true;
        } else {
            return '不是合法的文件';
        }
    }


    /**
     * 验证 逗号拼接的id (1,2,3)
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool|string
     */
    protected function isCommaSplitId($value, $rule = '', $data = '', $field = '')
    {
        $value = trim($value, ',');
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            $val = explode(',', $value);
            foreach ($val as $k => $v){
                if ( !( is_numeric($v) && is_int($v + 0) && ($v + 0) > 0 ) ) {
                    return $field . '每项必须是正整数';
                }
            }
            return true;
        }
    }


    /**
     * 检测是否是正确 url 地址
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool|string
     */
    protected function isUrl($value, $rule = '', $data = '', $field = '')
    {
        $rule = '(https?|ftp|file)://[-A-Za-z0-9+&@#/%?=~_|!:,.;]+[-A-Za-z0-9+&@#/%=~_|]';
        $result = preg_match($rule, $value);
        if ($result) {
            return true;
        } else {
            return $field.'格式不正确';
        }
    }


    /**
    *  检测参数中是否包含user_id, 获取rule验证的参数
    * @param $arrays
    * @return array
    * @throws ParameterException
    * $data = $validate->getDataByRule(input('post.'));
    */
    public function getDataByRule($arrays)
    {
        if(array_key_exists('user_id', $arrays) || array_key_exists('uid', $arrays)){
            // 不允许包含user_id uid, 防止恶意覆盖user_id外键
            throw new ParameterException([
                'message' => '参数中包含非法的参数名user_id或uid'
            ]);
        }
        $newArray = [];
        foreach ($this->rule as $k=>$v){
            if(array_key_exists($k,$arrays)){
                $newArray[$k] = $arrays[$k];
            }
        }
        return $newArray;
    }


    /**
     * 获取rule验证的参数
     * 不验证uid/user_id
     * @param $arrays
     * @return array
     */
    public function getRuleData($arrays)
    {
        $newArray = [];
        foreach ($this->rule as $k=>$v){
            if(array_key_exists($k,$arrays)){
                $newArray[$k] = $arrays[$k];
            }
        }
        return $newArray;
    }


}