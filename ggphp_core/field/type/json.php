<?php

/**
 *  
 */
class field_type_json extends field_type_base {

    public $type = 'text';
    public $widgetType = 'hidden';
    
    public function save($value) {
        return json_encode($value);
    }
    
    public function load($value) {
        return json_decode($value);
    }

}
