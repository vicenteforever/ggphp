<?php
//验证码程序封装
$prewd = getcwd();
$dir = dirname(__FILE__).DS."cool-php-captcha-0.3";
chdir($dir);
include($dir.DS."captcha.php");
chdir($prewd);