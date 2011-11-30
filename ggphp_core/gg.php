<?php

/*
 * @author goodzsq@gmail.com
 */
//定义环境变量
define("__VERSION__", "0.0.1");
define("GG_DIR", dirname(__FILE__));
define("DS", DIRECTORY_SEPARATOR);
//加载常用函数
require(GG_DIR . '/function.php');
if(file_exists(APP_DIR . '/function.php')){
	require(APP_DIR . '/function.php');
}
//系统设置
if(config('app', 'debug')){
	error_reporting(E_ALL);
}
else{
	error_reporting(E_ALL ^ E_NOTICE);
}
ini_set('track_errors', true);//将错误消息放到$php_errormsg中
ini_set('display_errors', true);//显示错误消息

if (version_compare(PHP_VERSION, "5.3.0") < 0) {
	set_magic_quotes_runtime(0);
}
else{
	ini_set("magic_quotes_runtime",0);
}


function __autoload($className){
	if(!preg_match("/^[_0-9a-zA-Z]+$/", $className))
		throw new Exception('invalid autoload');

	$basepath = str_replace('_', DS, $className);
	$path = APP_DIR.DS.'src'.DS.$basepath.".php";
	if(file_exists($path)){
		include($path);
	}
	else{
		$path = GG_DIR.DS.$basepath.".php";
		if(file_exists($path)){
			include($path);
		}
		else{
			throw new Exception(t('class not exists')."[:($className)]");
		}
	}
}

//set_error_handler("handleError", E_ALL);
//set_exception_handler("handleException");
/*
 * 错误处理
 */
function handleError() {
	$args = func_get_args();
	echo '<hr>error:';
	print_r($args);return;
	die('[error]');
}

/*
 * 异常处理
 */
function handleException() {
	$args = func_get_args();
	echo '<hr>exception:';
	print_r($args);return;
	die('[exception]');
}
