<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2017/12/5
 * Time: 下午12:00
 */

namespace app\api\com;


class HTTPStatusCode
{
    // Informational 1xx 用于指定客户端应相应的某些动作
    const CODE_CONTINUE = 100;
    const CODE_SWITCHING_PROTOCOLS = 101;

    // Success 2xx 用于表示请求成功
    const CODE_OK = 200;
    const CODE_CREATED = 210;
    const CODE_ACCEPTED = 202;
    const CODE_NON_AUTHORITATIVE_INFORMATION = 203;
    const CODE_NO_CONTENT = 204;
    const CODE_RESET_CONTENT = 205;
    const CODE_PARTIAL_CONTENT = 206;

    // Redirection 3xx 用于已经移动的文件并且常被包含在定位头信息中指定新的地址信息
    const CODE_MULTIPLE_CHOICES = 300;
    const CODE_MOVED_PERMANENTLY = 301;
    const CODE_MOVED_TEMPORARILY = 302;
    const CODE_SEE_OTHER = 303;
    const CODE_NOT_MODIFIED = 304;
    const CODE_USE_PROXY = 305;
    const CODE_TEMPORARY_REDIRECT = 307;

    // Client Error 4xx 用于指出客户端的错误
    const CODE_BAD_REQUEST = 400;
    const CODE_UNAUTHORIZED = 401;
    const CODE_PAYMENT_REQUIRED = 402;
    const CODE_FORBIDDEN = 403;
    const CODE_NOT_FOUND = 404;
    const CODE_METHOD_NOT_ALLOWED = 405;
    const CODE_NOT_ACCEPTABLE = 406;
    const CODE_PROXY_AUTHENTICATION_REQUIRED = 407;
    const CODE_REQUEST_TIMEOUT = 408;
    const CODE_CONFLICT = 409;
    const CODE_GONE = 410;
    const CODE_LENGTH_REQUIRED = 411;
    const CODE_PRECONDITION_FAILED = 412;
    const CODE_REQUIRED_ENTITY_TOO_LARGE = 413;
    const CODE_REQUEST_URI_TOO_LONG = 414;
    const CODE_UNSUPPORTED_MEDIA_TYPE = 415;
    const CODE_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const CODE_EXPECTATION_FAILED = 415;

    // Server Error 5xx 用于支持服务器错误
    const CODE_INTERNAL_SERVER_ERROR = 500;
    const CODE_NOT_IMPLEMENTED = 501;
    const CODE_BAD_GATEWAY = 502;
    const CODE_SERVICE_UNAVAILABLE = 503;
    const CODE_GATEWAY_TIMEOUT = 504;
    const CODE_HTTP_VERSION_NOT_SUPPORTED = 505;
    const CODE_BANDWIDTH_LIMIT_EXCEEDED = 509;

    private static $phrases = [
        // 继续发送请求
        100 => 'Continue',
        // 转换协议
        101 => 'Switching Protocols',
        // 处理将被继续执行
        102 => 'Processing',
        // 正常
        200 => 'OK',
        // 已创建
        201 => 'Created',
        // 接受
        202 => 'Accepted',
        // 非官方信息
        203 => 'Non-Authoritative Information',
        // 无内容
        204 => 'No Content',
        // 重置内容
        205 => 'Reset Content',
        // 局部内容
        206 => 'Partial Content',
        // 消息体将是一个XML消息, 并且可能依照之前子请求数量的不同，包含一系列独立的响应代码
        207 => 'Multi-status',
        208 => 'Already Reported',
        // 多重选择
        300 => 'Multiple Choices',
        // 请求的资源已永久移动到新位置
        301 => 'Moved Permanently',
        // 找到
        302 => 'Found',
        // 参见其他信息
        303 => 'See Other',
        // 未修正
        304 => 'Not Modified',
        // 使用代理
        305 => 'Use Proxy',
        // 在最新版的规范中，306状态码已经不再被使用。
        306 => 'Switch Proxy',
        // 临时重定向 请求的资源临时从不同的URI 响应请求
        307 => 'Temporary Redirect',
        // 错误请求
        400 => 'Bad Request',
        // 未授权
        401 => 'Unauthorized',
        // 该状态码是为了将来可能的需求而预留的。
        402 => 'Payment Required',
        // 禁止
        403 => 'Forbidden',
        // 未找到
        404 => 'Not Found',
        // 方法未允许
        405 => 'Method Not Allowed',
        // 无法访问
        406 => 'Not Acceptable',
        // 代理服务器认证要求
        407 => 'Proxy Authentication Required',
        // 请求超时
        408 => 'Request Time-out',
        // 冲突 该状态通常与PUT请求一同使用
        409 => 'Conflict',
        // 已经不存在
        410 => 'Gone',
        // 需要数据长度
        411 => 'Length Required',
        // 先决条件错误
        412 => 'Precondition Failed',
        // 请求实体过大
        413 => 'Request Entity Too Large',
        // 请求URI过长
        414 => 'Request-URI Too Large',
        // 不支持的媒体格式
        415 => 'Unsupported Media Type',
        // 请求范围无法满足
        416 => 'Requested range not satisfiable',
        // 期望失败
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        // 请求格式正确，但是由于含有语义错误，无法响应
        422 => 'Unprocessable Entity',
        // 当前资源被锁定
        423 => 'Locked',
        // 由于之前的某个请求发生的错误，导致当前请求失败
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        // 客户端应当切换到TLS/1.0
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        // 该请求因法律原因不可用
        451 => 'Unavailable For Legal Reasons',
        // 内部服务器错误
        500 => 'Internal Server Error',
        // 未实现 不支持请求中要求的功能
        501 => 'Not Implemented',
        // 错误的网关
        502 => 'Bad Gateway',
        // 服务无法获得
        503 => 'Service Unavailable',
        // 网关超时
        504 => 'Gateway Time-out',
        // 不支持的 HTTP 版本
        505 => 'HTTP Version not supported',
        // 服务器存在内部配置错误
        506 => 'Variant Also Negotiates',
        // 服务器无法存储完成请求所必须的内容
        507 => 'Insufficient Storage',
        // 服务器达到带宽限制
        508 => 'Loop Detected',
        511 => 'Network Authentication Required',
    ];

    static function getReasonPhrase($statusCode):?string
    {
        if(isset(self::$phrases[$statusCode])){
            return self::$phrases[$statusCode];
        }else{
            return null;
        }
    }
}