<?php

/**
 * file field
 * @package field
 * @author goodzsq@gmail.com
 */
class field_file extends field_base {

    public $defaultWidget = 'file';
    
    public function validate($value) {
        return true;
    }

    /**
     * @todo goodzsq field_file not implement
     */
}
