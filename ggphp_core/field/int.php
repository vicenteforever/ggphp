<?php

class field_int extends field_base {

    public $type = 'int';
    public $length = 11;
    public $widgetType = 'text';

    function validate($val) {
        if ( ($val === true) || ((string)(int) $val) !== ((string) $val)) {
            return "{$this->label} is not integer";
        }
        return true;
    }

}
