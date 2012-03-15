<?php

class field_text extends field_base {

    public $type = 'text';
    public $defaultWidget = 'textarea';

    function validate($value) {
        return true;
    }

}
