<?php

class field_email extends field_type {

    public $type = 'varchar';
    public $length = 255;
    public $widgetType = 'text';

    function validate($value) {
        if (strlen($value) > $this->length) {
            $this->error = "{$this->label}的长度必须小于{$this->length}";
            return false;
        } else if (!preg_match("/^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,6}$/i", $value)) {
            $this->error = "{$this->label}为非法的邮件格式";
            return false;
        }
        return true;
    }

}
