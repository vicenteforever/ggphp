<?php

/**
 * 字符串字段
 * @package field
 * @author goodzsq@gmail.com
 */class field_type_string extends field_type_base {

    public $type = 'string';
    public $length = 255;
    public $default = '';
    public $widgetType = 'text';
    public $validators = array('string');
}
