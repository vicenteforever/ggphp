<?php

/**
 * 系统日志
 * @package advice
 */
class advice_log extends advice_base {

    public function after($class, $method, $args, $return) {
        app()->log("控制器结束:$class::$method");
        return $return;
    }

    public function before($class, $method, $args) {
        app()->log("控制器开始:$class::$method");
    }

    public function except($class, $method, $args, Exception $except) {
        $message = $except->getMessage() . "@" . addslashes($except->getFile()) . ' ' . $except->getLine() . '行';
        app()->log("控制器出现异常 [$message]", $except->getTrace(), core_app::LOG_ERROR);
    }

}
