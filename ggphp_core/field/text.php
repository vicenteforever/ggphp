<?php

class field_text extends field_base {

    public $type = 'text';

    function validate($value) {
        return true;
    }

}
