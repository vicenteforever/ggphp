<?php

class field_int extends field_base {

    public $type = 'int';
    public $length = 11;
    public $widgetType = 'text';
    public $validators = array('int');
    
}
