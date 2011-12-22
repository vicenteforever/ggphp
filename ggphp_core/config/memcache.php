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

//单个memcache服务器
$config['group'] = array($server1);

//双组集群设置，具有容错功能
//$config['group1'] = array($server1,$server2);
//$config['group2'] = array($server3, $server4);

//单组多个服务器集群，不具有容错功能
//$config['group'] = array($server1, $server2);

return $config;