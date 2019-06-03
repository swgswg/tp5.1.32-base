<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2019/5/11
 * Time: 17:16
 */

use think\Container;

class HttpServer
{
    public function __construct($config = [])
    {
        $http = new Swoole\Http\Server("0.0.0.0", 9501);
        $http->set($config);
        $http->on('request', [$this, 'onRequest']);
        $http->on('workStart', [$this, 'onWorkStart']);
        $http->start();
    }

    public function onRequest($request, $response)
    {
        if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
            return $response->end();
        }
        if(isset($request->server)){
            $_SERVER = [];
            foreach ($request->server as $k=>$v){
                $_SERVER[strtoupper($k)] = $v;
            }
        }

        if(isset($request->header)){
            $http_response_header = [];
            foreach ($request->header as $k=>$v){
                $http_response_header[$k] = $v;
            }
        }

        if(isset($request->get)){
            $_GET = [];
            foreach ($request->get as $k=>$v){
                $_GET[$k] = $v;
            }
        }

        if(isset($request->post)){
            $_POST = [];
            foreach ($request->post as $k=>$v){
                $_POST[$k] = $v;
            }
        }

        if(isset($request->cooike)){
            $_COOKIE = [];
            foreach ($request->cooike as $k=>$v){
                $_COOKIE[$k] = $v;
            }
        }

        if(isset($request->file)){
            $_FILES = [];
            foreach ($request->file as $k=>$v){
                $_FILES[$k] = $v;
            }
        }

        ob_start();
        // 执行应用并响应
        Container::get('app')->run()->send();
        $res = ob_get_contents();
        ob_end_clean();
        $response->end($res);
    }


    public function onWorkStart(Swoole\Http\Server $server, $worker_id)
    {
        if(!$server->taskworker){
            // 加载基础文件
            require_once __DIR__ . '/../thinkphp/base.php';
        }
    }
}


$config = [
    'worker_num' => 2,
    'task_worker_num' => 50,
    'package_max_length' => 1024*1024*10, // 10M
    'daemonize' => 0,
    'upload_tmp_dir' => __DIR__. '/tmp/uploadfiles/',

];
new HttpServer($config);