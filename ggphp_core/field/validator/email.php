<?php

/**
 * 电子邮件校验
 * @package validator
 * @author goodzsq@gmail.com
 */
class field_validator_email implements field_validator_interface {

    public function validate(field_type_base $field, $value) {
        if (!preg_match("/^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,6}$/i", $value)) {
            return "{$field->label}格式错误";
        }
        return true;
    }

    public function setting() {
        return;
    }

}

