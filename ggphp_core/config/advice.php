<?php

$common = array('log', 'report');
$auth = array('auth');
$advice['*']['*'] = $common;
$advice['test_controller']['*'] = array_merge($common, $auth);
return $advice;