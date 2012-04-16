<?php

/**
 * 下拉列表或单选按钮
 * @package widget_field
 * @author goodzsq@gmail.com
 */
class field_widget_list {

    /**
     * 下拉列表
     * @param field_type_base $field
     * @return string
     */
    public function style_default(field_type_base $field, $value) {
        $buf = "<label>{$field->label}\n  <select name='{$field->name}'>\n";
        $buf .= "    <option></option>";
        foreach ($field->getList('dict') as $k => $v) {
            if ($k == $value) {
                $selected = ' selected';
            } else {
                $selected = '';
            }
            $buf .= "    <option value='{$k}'{$selected}>[$k] {$v}</option>\n";
        }
        $buf .= "  </select>\n<label class='tip' name='{$field->name}'></label></label>";
        return $buf;
    }
    
    /**
     * 级联下拉列表
     * @param field_type_base $field
     * @return type 
     */
    public function style_level(field_type_base $field, $value){
        $selector = ":input[name={$field->name}]";
        jquery_plugin()->ajaxLevelSelect($selector, abs_url($field->dict));

        $buf = "<label>{$field->label}\n  <input type='text' name='{$field->name}' value='$value'>\n";
        $buf .= "<label class='tip' name='{$field->name}'></label></label>";
        return $buf;
    }

    /**
     * 单选按钮组
     * @param field_type_base $field
     * @return string 
     */
    public function style_radio(field_type_base $field, $value) {
        $buf = "<label>{$field->label} \n";
        foreach ($field->getList('dict') as $k => $v) {
            if ($k == $value) {
                $checked = ' checked="checked"';
            } else {
                $checked = '';
            }
            $buf .= "<label><input type='radio' name='{$field->name}' value='{$k}'{$checked} />{$v}</label> \n";
        }
        $buf .= "<label class='tip' name='{$field->name}'></label>";
        return $buf;
    }

}

