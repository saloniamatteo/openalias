<?php

require_once('vendor/autoload.php');

/**
 * Class FlushRedis
 * Gets rid of everything in Redis.
 * We recommend running this about every 5-10 minutes.
 */
class FlushRedis
{

    private $redis;

    public function __construct()
    {
        $ini = parse_ini_file(__DIR__ . '/config.ini', true);
        $this->redis = new Credis_Client($ini['redis']['host'], $ini['redis']['port']);
    }

    public function flush() {
        $this->redis->flushAll();
    }
}

$Redis = new FlushRedis();
$Redis->flush();
