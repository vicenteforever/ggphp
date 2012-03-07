<?php

class field_string_type extends field_base {

    public $type = 'string';
    public $length = 255;

    function validate($value) {
        if (strlen($value) > $this->length) {
            return "{$this->label} must little then {$this->length}";
        }
        return parent::validate($value);
    }

    public function widget_input($value) {
        return "<label>{$this->label}</label> <input type=\"text\" name=\"{$this->name}\" value=\"{$value}\" />";
    }

}
