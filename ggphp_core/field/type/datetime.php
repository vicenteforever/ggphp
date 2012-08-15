<?php

/**
 * 日期类型字段
 * @package field
 * @author goodzsq@gmail.com
 */class field_type_datetime extends field_type_base {

    public $type = 'datetime';
    public $widget = 'text';
    public $validators = array('datetime');
    
}
