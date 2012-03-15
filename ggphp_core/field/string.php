<?php

class field_string extends field_base {

    public $type = 'string';
    public $length = 255;
    public $defaultWidget = 'text';

    function validate($value) {
        if (strlen($value) > $this->length) {
            return "{$this->label} must little then {$this->length}";
        }
        return true;
    }

}
