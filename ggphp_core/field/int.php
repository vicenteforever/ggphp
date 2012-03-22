<?php

class field_int extends field_base {

    public $type = 'int';
    public $length = 11;
    public $defaultWidget = 'text';

    function validate($value) {
        if ( ($val === true) || ((string)(int) $val) !== ((string) $val)) {
            return "{$this->label} is not integer";
        }
        return true;
    }

}
