<?php

/**
 * 单行文本
 * @package widget_field
 * @author goodzsq@gmail.com
 */
class widget_field_text {

    /**
     * 普通单行文本
     * @param field_base $field
     * @return string 
     */
    static public function style_default(field_base $field) {
        return "<label>{$field->label}<input type='text' name={$field->name} value='{$field->getValue()}' /><label class='tip' name='{$field->name}'></label></label>";
    }

    /**
     * 自动完成输入文本
     * @param field_base $field
     * @return string 
     */
    static public function style_autocomplete(field_base $field) {
        $selector = ":input[name={$field->name}]";
        jquery_ui()->autocomplete($selector);
        return "<label>{$field->label}<input type='text' name={$field->name} value='{$field->getValue()}'><label class='tip' name='{$field->name}'></label></label>";
    }

}

