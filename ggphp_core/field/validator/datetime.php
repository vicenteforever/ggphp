<?php

/**
 * 日期格式校验
 * @package validator
 * @author goodzsq@gmail.com
 */
class field_validator_datetime implements field_validator_interface {

    public function validate(field_type_base $field) {
        @list($date, $time) = explode(' ', trim($field->value));
        //判断日期
        if (!preg_match("/^(\d{4})-?(\d{1,2})-?(\d{1,2})$/", $date, $match)) {
            return "非法的日期";
        } else if (!checkdate($match[2], $match[3], $match[1])) {
            return "非法的日期";
        }
        //判断时间
        if (isset($time)) {
            if (!preg_match("/^(\d{1,2}):(\d{1,2}):(\d{1,2})$/", $time, $match)) {
                return "非法的时间格式";
            } else if ($match[1] > 23 || $match[2] > 60 || $match[3] > 60) {
                return "非法的时间";
            }
        }
        return true;
    }

    public function setting() {
        return;
    }

}

