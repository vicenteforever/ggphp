<?php

/**
 * 输入校验器
 * @package validator
 * @author goodzsq@gmail.com
 */
interface validator_interface {
    public function validate(field_base $field);
    public function setting();
}

