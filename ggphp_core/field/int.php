<?php

class field_int extends field_base {

    public $type = 'int';
    public $length = 11;

    function validate($value) {
        $value2 = (int) $value . '';
        if ($value != $value2) {
            return "{$this->label} is not integer";
        }
        return true;
    }

}
