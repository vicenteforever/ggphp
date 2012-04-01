<?php

class field_type_datetime extends field_type_base {

    public $type = 'datetime';
    public $length = null;
    public $widgetType = 'text';
    public $validators = array('datetime');
    
}
