<?php
$config['default'] = array(
	'DSN' => 'mysql:host=localhost;dbname=dmc',
	'username' => 'root',
	'password' => 'root',
	'driver_opts' => array(),
	'charset' => 'utf8',
);

$config['test'] = array(
	'DSN' => 'mysql:host=localhost;dbname=test',
	'username' => 'root',
	'password' => 'root',
	'driver_opts' => array(),
	'charset' => 'utf8',
);

return $config;