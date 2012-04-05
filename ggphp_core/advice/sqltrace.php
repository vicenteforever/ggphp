<?php

/**
 * 跟踪sql输出
 * @package core
 * @author goodzsq@gmail.com
 */
class advice_sqltrace extends advice_base {
    public function after($class, $method, $args, $return) {
        app()->log('sql execute end');
        return $return;
    }
    
    public function before($class, $method, $args) {
        app()->log('sql execute start:' . $args[0]);
    }
    
    public function except($class, $method, $args, $except) {
        app()->log('sql execute fail:' . $except->getMessage());
    }
}
