<?php

class field_password extends field_base {

    public $type = 'string';
    public $length = 255;
    public $defaultWidget = 'password';

    function validate($value) {
        return true;
    }

}
