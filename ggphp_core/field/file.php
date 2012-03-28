<?php

/**
 * file field
 * @package field
 * @author goodzsq@gmail.com
 */
class field_file extends field_base {

    public $widgetType = 'file';
    public $type = 'text';

    public function validate($value) {
        return true;
    }

    public function getValue() {
        return serialize(parent::getValue());
    }

    public function setValue($value) {
        if(!is_array($value)){
            $value = array();
        }
        if(!is_array($this->value)){
            $this->value = array();
        }
        $new = array_merge($this->value, $value);
        parent::setValue($new);
    }

}
