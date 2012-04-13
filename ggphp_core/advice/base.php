<?php

/**
 * 拦截器对象基类
 * @package advise 
 */
class advice_base implements advice_interface {

    public function after($class, $method, $args, $return) {
        return $return;
    }

    public function before($class, $method, $args) {
        
    }

    public function except($class, $method, $args, Exception $except) {
        
    }

    public function setting() {

    }
    
}
