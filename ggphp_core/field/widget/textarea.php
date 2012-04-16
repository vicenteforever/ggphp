<?php

/**
 * 多行文本
 * @package widget_field
 * @author goodzsq@gmail.com
 */
class field_widget_textarea {

    /**
     * 普通多行文本输入
     * @param field_type_base $field
     * @return string 
     */
    public function style_default(field_type_base $field, $value) {
        return "<label>{$field->label}<textarea name='{$field->name}'>{$value}</textarea><label class='tip' name='{$field->name}'></label></label>";
    }

    /**
     * 多行文本tinymce编辑器
     * @param field_type_base $field
     * @return string 
     */
    public function style_tinymce(field_type_base $field, $value) {
        $selector = ":input[name={$field->name}]";
        jquery_plugin()->tinymce($selector);
        return self::style_default($field, $value);
    }


}

