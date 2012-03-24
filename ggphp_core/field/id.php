<?php

class field_id extends field_base {

    public $type = 'int';
    public $length = 11;
    public $primary = true;
    public $serial = true;
    public $widgetType = 'hidden';

    function validate($value) {
        if (empty($value)) {
            return true;
        } else {
            $value2 = (int) $value . '';
            if ($value != $value2) {
                return "{$this->label} is not integer";
            }
            return true;
        }
    }

}
