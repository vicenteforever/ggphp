<?php

/**
 * csrf校验
 * @package field 
 * @author $goodzsq@gmail.com
 */
class field_type_csrf extends field_type_base {

    public $widget = 'csrf';
    public $isHidden = true;
    public $isDatabase = false;
    
    public function validate($value) {
        return util_csrf::validate($value);
    }

}