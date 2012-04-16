<?php

/**
 * 字符串校验
 * @package validator
 * @author goodzsq@gmail.com
 */
class field_validator_string implements field_validator_interface {

    public function validate(field_type_base $field, $value) {
        if (strlen($value) > $field->length) {
            return "{$field->label}长度必须小于{$field->length}";
        }
        return true;
    }

    public function setting() {
        return;
    }

}

