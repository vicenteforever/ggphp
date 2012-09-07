<?php

/**
 * PHP序列化存储
 * @package field
 * @author $goodzsq@gmail.com
 */
class field_encoder_serialize implements field_encoder_interface {

    public function decode($value) {
        return unserialize($value);
    }

    public function encode($value) {
        return serialize($value);
    }

}