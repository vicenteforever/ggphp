<?php

$config['default'] = array(
    'dsn' => 'mysql:host=localhost;dbname=ggcms',
    'host' => 'localhost',
    'database' => 'ggcms',
    'username' => 'root',
    'password' => '',
    'options' => array(),
);

$config['test'] = array(
    'dsn' => 'mysql:host=localhost;dbname=test',
    'username' => 'root',
    'password' => '',
    'options' => array(),
);

return $config;