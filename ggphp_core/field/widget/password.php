<?php

/**
 * 密码字段
 * @package widget_field
 * @author goodzsq@gmail.com
 */
class field_widget_password {

    /**
     * 密码字段
     * @param field_type_base $field
     * @return string 
     */
    public function style_default(field_type_base $field) {
        return "<label>{$field->label}<input type='password' name={$field->name} value='{$field->getValue()}'><label class='tip' name='{$field->name}'></label></label>";
    }

}

