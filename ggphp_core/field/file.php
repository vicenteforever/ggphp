<?php

/**
 * file field
 * @package field
 * @author goodzsq@gmail.com
 */
class field_file extends field_base {

    public $widgetType = 'file';
    
    public function validate($value) {
        return true;
    }

}
