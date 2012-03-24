<?php

class field_image extends field_file {

    public $type = 'varchar';
    public $length = 255;
    public $widgetType = 'text';

    function isValidFormat($value) {
        if (!parent::isValidFormat($value))
            return false;
        if (!preg_match("/(png|jpg|gif|jpeg|bmp)$/i", $value)) {
            $this->error = "{$this->label}是非法的图片格式";
            return false;
        }
        return true;
    }

}
