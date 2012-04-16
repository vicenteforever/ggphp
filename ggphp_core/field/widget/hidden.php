<?php

/**
 * 隐藏字段
 * @package widget_field
 * @author goodzsq@gmail.com
 */
class field_widget_hidden {

    /**
     * 隐藏字段
     * @param field_type_base $field
     * @return type 
     */
    public function style_default(field_type_base $field, $value) {
        return "<input type='hidden' name='{$field->name}' value='$value' />";
    }

}

