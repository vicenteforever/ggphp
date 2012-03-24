<?php

class field_text extends field_base {

    public $type = 'text';
    public $widgetType = 'textarea';

    function validate($value) {
        return true;
    }

}
