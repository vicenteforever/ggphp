<?php
$config['default'] = array(
	'DSN' => 'mysql:host=localhost;dbname=test',
	'host' => 'localhost',
	'database' => 'test',
	'username' => 'root',
	'password' => '',
	'driver_opts' => array(),
);

$config['test'] = array(
	'DSN' => 'mysql:host=localhost;dbname=test',
	'username' => 'root',
	'password' => 'root',
	'driver_opts' => array(),
);

return $config;