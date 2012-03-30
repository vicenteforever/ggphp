<?php

class field_datetime extends field_base {

    public $type = 'datetime';
    public $length = null;
    public $widgetType = 'text';
    public $validators = array('datetime');
    
}
