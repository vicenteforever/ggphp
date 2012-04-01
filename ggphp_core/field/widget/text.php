<?php

/**
 * 单行文本
 * @package widget_field
 * @author goodzsq@gmail.com
 */
class field_widget_text {

    /**
     * 普通单行文本
     * @param field_type_base $field
     * @return string 
     */
    static public function style_default(field_type_base $field) {
        return "<label>{$field->label}<input type='text' name={$field->name} value='{$field->getValue()}' /><label class='tip' name='{$field->name}'></label></label>";
    }

    /**
     * 自动完成输入文本
     * @param field_type_base $field
     * @return string 
     */
    static public function style_autocomplete(field_type_base $field) {
        $selector = ":input[name={$field->name}]";
        jquery_ui()->autocomplete($selector);
        return "<label>{$field->label}<input type='text' name={$field->name} value='{$field->getValue()}'><label class='tip' name='{$field->name}'></label></label>";
    }

}

