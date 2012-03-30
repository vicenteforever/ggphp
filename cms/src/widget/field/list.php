<?php

/**
 * 下拉列表或单选按钮
 * @package widget_field
 * @author goodzsq@gmail.com
 */
class widget_field_list {

    /**
     * 下拉列表
     * @param field_base $field
     * @return string
     */
    public function style_default(field_base $field) {
        $buf = "<label>{$field->label}\n  <select name='{$field->name}'>\n";
        $buf .= "    <option></option>";
        foreach ($field->getList('dict') as $k => $v) {
            if ($k == $field->getValue()) {
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
     * @param field_base $field
     * @return type 
     */
    public function style_level(field_base $field){
        $selector = ":input[name={$field->name}]";
        jquery_plugin()->ajaxLevelSelect($selector, abs_url($field->dict));

        $buf = "<label>{$field->label}\n  <input type='text' name='{$field->name}' value='{$field->getValue()}'>\n";
        $buf .= "<label class='tip' name='{$field->name}'></label></label>";
        return $buf;
    }

    /**
     * 单选按钮组
     * @param field_base $field
     * @return string 
     */
    public function style_radio(field_base $field) {
        $buf = "<label>{$field->label} \n";
        foreach ($field->getList('dict') as $k => $v) {
            if ($k == $field->getValue()) {
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

