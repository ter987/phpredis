<?php
namespace gaodun\phpredis;

class Redis
{
    protected $host = REDIS_HOST;
    protected $port = REDIS_PORT;
    protected $password = REDIS_PASSWORD;
    protected $redis;
    protected $redisCommand = [];
    static $instance;

    private function __construct()
    {
        if (!extension_loaded('redis')) {
            throw new \Exception('没有php_redis扩展');
        }
        echo $this->port;exit;
        $this->connect();
    }

    public function connect(){
        try{
            $this->redis = new \Redis();
            $this->redis->pconnect($this->host,$this->port);
            if (!empty($this->password)) {
                $this->redis->Auth($this->password);
            }
            $response = $this->redis->ping();
            if ($response != '+PONG') {
                throw new \Exception($response, 1);
            }
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }
    public static function getInstance(){
        if(self::$instance == null){
            self::$instance =  new Redis();
        }
        return self::$instance;
    }

    public function __call($method, $param)
    {
        $method = strtoupper($method);
        $count = count($param);
        switch ($count) {
            case 0 :
                return $this->redis->$method();
                break;
            case 1 :
                return $this->redis->$method($param[0]);
                break;
            case 2 :
                return $this->redis->$method($param[0], $param[1]);
                break;
            case 3 :
                return $this->redis->$method($param[0], $param[1], $param[2]);
                break;
        }
    }
}