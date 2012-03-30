<?php

/**
 * 字符串校验
 * @package validator
 * @author goodzsq@gmail.com
 */
class validator_string implements validator_interface {

    public function validate(field_base $field) {
        if (strlen($field->value) > $field->length) {
            return "{$field->label}长度必须小于{$field->length}";
        }
        return true;
    }

    public function setting() {
        return;
    }

}

