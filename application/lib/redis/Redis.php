<?php
/**
 * Created by PhpStorm.
 * User: song
 * Date: 2019/7/29
 * Time: 15:30
 */

namespace app\lib\redis;


use app\api\com\Singleton;

class Redis
{
    use Singleton;
    private $redis;
    private $options;

    private function __construct($config = [])
    {
        if(!extension_loaded('redis')){
            throw new \Exception('请安装redis扩展');
        }

        if (!empty($redisConfig)) {
            $this->options = array_merge(config('redis'), $config);
        }
    }


    /**
     * 连接Redis
     * @throws \Exception
     */
    protected function connect()
    {
        try{
            $this->redis = new \Redis;
            if ($this->options['persistent']) {
                $this->redis->pconnect($this->options['host'], $this->options['port'], $this->options['timeout'], 'persistent_id_' . $this->options['select']);
            } else {
                $this->redis->connect($this->options['host'], $this->options['port'], $this->options['timeout']);
            }
            if ('' != $this->options['password']) {
                $this->redis->auth($this->options['password']);
            }

            if (0 != $this->options['select']) {
                $this->redis->select($this->options['select']);
            }
        } catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }


    /**
     * @return null
     * @throws \Exception
     */
    public function handler()
    {
        try{
            $this->connect();
        } catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
        return $this->redis;
    }



    /**
     *
     * @param $key
     * @param $value
     * @param null $expire
     * @return mixed
     * @throws \Exception
     */
    public function set($key, $value, $expire = null)
    {
        if($expire > 0){
            $res = $this->handler()->setex($key, $expire,$value);
        } else {
            $res = $this->handler()->set($key, $value);
        }
        return $res;
    }


    /**
     * 调用redis方法, 不在这个类中, 用__call去redis中找
     * @param $name
     * @param $arguments
     * @return array|bool|mixed
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if(method_exists($this->redis, $name)){
            try {
                if ('scan' == $name) {
                    $data = $this->redis->scan($arguments[0]);
                } else {
                    $data =  call_user_func_array([$this->redis, $name], $arguments);
                }
                return $data;
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        } else {
            throw new \Exception('redis方法不存在');
        }
    }
}