<?php

/**
 * 整数字段
 * @package field
 * @author goodzsq@gmail.com
 */
class field_type_int extends field_type_base {

    public $type = 'int';
    public $length = 11;
    public $widgetType = 'text';
    public $validators = array('int');
    
}
