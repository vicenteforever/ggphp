<?php

/**
 * 输入校验器
 * @package validator
 * @author goodzsq@gmail.com
 */
interface field_validator_interface {
    public function validate(field_type_base $field);
    public function setting();
}

