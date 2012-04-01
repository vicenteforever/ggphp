<?php

/**
 * 整数校验
 * @package validator
 * @author goodzsq@gmail.com
 */
class field_validator_int implements field_validator_interface {

    public function validate(field_type_base $field) {
        if (($field->value === true) || ((string) (int) $field->value) !== ((string) $field->value)) {
            return "{$field->label} 不是整数";
        }
        if (isset($field->minvalue) && $field->value < $field->minvalue) {
            return "{$field->label} 必须大于等于 {$field->minvalue}";
        }
        if (isset($field->maxvalue) && $field->value > $field->maxvalue) {
            return "{$field->label} 必须小于等于 {$field->maxvalue}";
        }
        return true;
    }

    public function setting() {
        $result[] = array('name' => 'minvalue', 'label' => '最小值', 'value' => '');
        $result[] = array('name' => 'minvalue', 'label' => '最大值', 'value' => '');
        return $result;
    }

}

