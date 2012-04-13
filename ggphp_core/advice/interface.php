<?php

/**
 * 实现切面增强的接口
 * @package advice 
 */
interface advice_interface {

    public function before($class, $method, $args);

    public function after($class, $method, $args, $return);

    public function except($class, $method, $args, Exception $except);

    public function setting();
    
}