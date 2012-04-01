<?php

class field_type_string extends field_type_base {

    public $type = 'string';
    public $length = 255;
    public $widgetType = 'text';
    public $validators = array('string');
}
