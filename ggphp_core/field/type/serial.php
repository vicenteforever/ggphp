<?php

/**
 * 自动加一字段，仅用于主键
 * @package field
 * @author goodzsq@gmail.com
 */
class field_type_serial extends field_type_base {

    public $type = 'int';
    public $length = 11;
    public $index = 'primary';
    public $serial = true;
    public $widget = 'hidden';
    
}
