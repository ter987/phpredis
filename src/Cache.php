<?php
namespace gaodun\phpredis;

use gaodun\phpredis\Redis;

class Cache
{
    public $redis;

    public function __construct()
    {
        $this->redis = Redis::getInstance();
    }

    public function set($key, $value, $expire = 0)
    {
        $value = serialize($value);
        if (!empty($expire)) {
            $this->redis->set($key, $value);
            $this->redis->expire($key, $expire);
        } else {
            $this->redis->set($key, $value);
        }
    }

    public function get($key)
    {
        $value = $this->redis->get($key);
        if (!empty($value)) {
            return unserialize($value);
        } else {
            return null;
        }
    }

    /**
     * 删除缓存 如果$key为数组可同时删除多个
     * @param $key string|array
     */
    public function del($key)
    {
        $this->redis->del($key);
    }
}