<?php

/**
 * 增强对象基类
 * @package advise 
 */
class advice_base implements advice_interface {

    public function after($name, $args, $return) {
        return $return;
    }

    public function before($name, $args) {
        
    }

    public function except($name, $args, $except) {
        
    }

}

?>
