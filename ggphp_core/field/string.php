<?php

class field_string extends field_base {

    public $type = 'string';
    public $length = 255;
    public $widgetType = 'text';
    public $validators = array('string');
}
