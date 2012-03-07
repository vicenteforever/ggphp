<?php

class field_password_type extends field_base {

    public $type = 'string';
    public $length = 255;

    function validate($value) {
        return parent::validate($value);
    }

    public function widget_input($value) {
        return "<label>{$this->label}</label> <input type=\"password\" name=\"{$this->name}\" value=\"\" />";
    }

}
