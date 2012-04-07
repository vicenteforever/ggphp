<?php

$config['default'] = array(
    'dsn' => 'mysql:host=localhost;dbname=ggcms',
    'host' => 'localhost',
    'database' => 'ggcms',
    'username' => 'root',
    'password' => 'root',
    'options' => array(),
);

$config['test'] = array(
    'dsn' => 'mysql:host=localhost;dbname=test',
    'username' => 'root',
    'password' => 'root',
    'options' => array(),
);

return $config;