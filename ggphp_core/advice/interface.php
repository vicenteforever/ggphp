<?php

/**
 * 实现切面增强的接口
 * @package advice 
 */
interface advice_interface {

    public function before($name, $args);

    public function after($name, $args, $return);

    public function except($name, $args, $except);
}