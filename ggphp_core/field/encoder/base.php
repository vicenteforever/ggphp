<?php

/**
 * 最基本的存取的实现
 * @package field
 * @author $goodzsq@gmail.com
 */
class field_encoder_base implements field_encoder_interface {

    public function decode($value) {
        return $value;
    }

    public function encode($value) {
        return $value;
    }

}