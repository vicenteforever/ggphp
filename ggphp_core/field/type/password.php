<?php

/**
 * 密码字段
 * @package field
 * @author goodzsq@gmail.com
 */
class field_type_password extends field_type_base {

    public $type = 'string';
    public $length = 255;
    public $widgetType = 'password';

}
