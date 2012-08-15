<?php

/**
 * 电子邮件字段
 * @package field
 * @author goodzsq@gmail.com
 */
class field_type_email extends field_type_base {

    public $type = 'string';
    public $length = 255;
    public $widget = 'text';
    public $validators = array('int');
}
