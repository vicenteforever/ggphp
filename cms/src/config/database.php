<?php

$config['default'] = array(
    'host' => 'localhost',
    'database' => 'ggcms',
    'username' => 'root',
    'password' => 'root',
    'driver_opts' => array(),
);

$config['test'] = array(
    'DSN' => 'mysql:host=localhost;dbname=test',
    'username' => 'root',
    'password' => 'root',
    'driver_opts' => array(),
);

return $config;