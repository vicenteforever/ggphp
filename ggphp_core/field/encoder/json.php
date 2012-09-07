<?php

/**
 * json存取
 * @package field
 * @author $goodzsq@gmail.com
 */
class field_encoder_json implements field_encoder_interface {

    public function decode($value) {
        return json_decode($value);
    }

    public function encode($value) {
        return json_encode($value);
    }

}