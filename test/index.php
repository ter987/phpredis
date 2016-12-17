<?php
require_once dirname(__FILE__).'/autoload.php';
use gaodun\phpredis\Cache;
$redis = new Cache();
$redis->set('tests', 'nihao');
$result = $redis->get('tests');
var_dump($result);