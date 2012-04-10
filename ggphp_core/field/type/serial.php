<?php

class field_type_serial extends field_type_base {

    public $type = 'int';
    public $length = 11;
    public $index = 'primary';
    public $serial = true;
    public $widgetType = 'hidden';
    
}
