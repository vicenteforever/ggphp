<?php

/**
 * 隐藏字段
 * @package widget_field
 * @author goodzsq@gmail.com
 */
class widget_field_hidden {

    /**
     * 隐藏字段
     * @param field_base $field
     * @return type 
     */
    public function style_default(field_base $field) {
        return "<input type='hidden' name='{$field->name}' value='{$field->getValue()}' />";
    }

}

