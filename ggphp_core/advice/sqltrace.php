<?php

/**
 * 跟踪sql输出
 * @package core
 * @author goodzsq@gmail.com
 */
class advice_sqltrace extends advice_base {
    public function after($name, $args, $return) {
        app()->log('sql execute end');
        return $return;
    }
    
    public function before($name, $args) {
        app()->log('sql execute start:' . $args[0]);
    }
    
    public function except($name, $args, $except) {
        app()->log('sql execute fail:' . $except->getMessage());
    }
}
