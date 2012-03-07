<?php

class field_id_type extends field_base {

    public $type = 'int';
    public $length = 11;
    public $primary = true;
    public $serial = true;

    function validate($value) {
        if (empty($value)) {
            return true;
        } else {
            $value2 = (int) $value . '';
            if ($value != $value2) {
                return "{$this->label} is not integer";
            }
            return parent::validate($value);
        }
    }

    public function widget_input($value) {
        return "<input type=\"hidden\" name=\"{$this->name}\" value=\"{$value}\" />";
    }

}
