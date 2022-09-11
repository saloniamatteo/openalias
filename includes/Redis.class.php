<?php
class Redis
{

    private $redis;

    public function __construct()
    {
        $ini = parse_ini_file(__DIR__ . '/../config.ini', true);
        $this->redis = new Credis_Client($ini['redis']['host'], $ini['redis']['port']);
    }

    public function write($key, $value) {
        $this->redis->set($key, $value);
    }

    public function get($key) {
        return $this->redis->get($key);
    }

}
