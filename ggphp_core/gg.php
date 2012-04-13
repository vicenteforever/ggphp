<?php

/*
 * ggphp env setting
 * @author goodzsq@gmail.com
 */
//定义环境变量
define("__VERSION__", "0.0.1");
define("GG_DIR", dirname(__FILE__));
define("DS", DIRECTORY_SEPARATOR);

//自动加载类
class GGLoader {

    public static function load($className) {
        if (!preg_match("/^[_0-9a-zA-Z]+$/", $className)) {
            app()->log('自动加载非法的类名称', $className, core_app::LOG_ERROR);
            return;
        }
        $basepath = str_replace('_', DS, $className);
        $path = APP_DIR . DS . 'src' . DS . $basepath . ".php";
        if (file_exists($path)) {
            include($path);
        } else {
            $path = GG_DIR . DS . $basepath . ".php";
            if (file_exists($path)) {
                include($path);
            } else {
                //app()->log('类不存在', $className, core_app::LOG_WARN);
                return;
            }
        }
    }

}

spl_autoload_register("GGLoader::load");

//加载常用函数
require(GG_DIR . '/function.php');
if (file_exists(APP_DIR . '/src/function.php')) {
    require(APP_DIR . '/src/function.php');
}
//设置系统时区
date_default_timezone_set(config('app', 'timezone'));
//系统设置
if (config('app', 'debug')) {
    error_reporting(E_ALL);
} else {
    error_reporting(E_ALL ^ E_NOTICE);
}
ini_set('track_errors', true); //将错误消息放到$php_errormsg中
ini_set('display_errors', true); //显示错误消息

if (version_compare(PHP_VERSION, "5.3.0") < 0) {
    set_magic_quotes_runtime(0);
} else {
    ini_set("magic_quotes_runtime", 0);
}

//set_error_handler("handleError", E_ALL);
//set_exception_handler("handleException");
/*
 * 错误处理
 */
function handleError() {
    $args = func_get_args();
    echo '<hr>error:';
    print_r($args);
    return;
    die('[error]');
}

/*
 * 异常处理
 */

function handleException() {
    $args = func_get_args();
    echo '<hr>exception:';
    print_r($args);
    return;
    die('[exception]');
}
