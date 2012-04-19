<?php

/**
 * 数据结构字段并以json方式存储
 * @package field
 * @author goodzsq@gmail.com
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
