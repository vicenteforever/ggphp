<?php

/**
 * 跟踪sql输出
 * @package core
 * @author goodzsq@gmail.com
 */
class advice_sqltrace extends advice_base {
    public function after($class, $method, $args, $return) {
        app()->log('SQL执行完毕');
        return $return;
    }
    
    public function before($class, $method, $args) {
        app()->log('SQL开始执行', $args[0]);
    }
    
    public function except($class, $method, $args, $except) {
        $message = $except->getMessage() . "@" . addslashes($except->getFile()) . ' ' . $except->getLine() . '行';
        app()->log("SQL执行失败 [$message]", $except->getTrace(), core_app::LOG_ERROR);
    }
}
