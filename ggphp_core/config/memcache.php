<?php
//分布式memcache主机列表
$server1 = array(
	'host' => '127.0.0.1',
	'port' => 11211,
);

$server2 = array(
	'host' => '127.0.0.1',
	'port' => 11212,
);

$server3 = array(
	'host' => '127.0.0.1',
	'port' => 11213,
);

$server4 = array(
	'host' => '127.0.0.1',
	'port' => 11214,
);

//分组集群设置
$config['group1'] = array($server1,$server2);
$config['group2'] = array($server3, $server4);

//$config['group'] = array($server1, $server2, $server3, $server4);

return $config;