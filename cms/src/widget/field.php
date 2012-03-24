<?php

/**
 * 录入字段
 * @package widget
 * @author goodzsq@gmail.com
 */
class widget_field extends widget_base {

    public function theme_default() {
        if ($this->_data instanceof field_base) {
            $methodName = "field_{$this->_data->widgetType}_{$this->_data->widget}";
            if (!method_exists($this, $methodName)) {
                $methodName = "field_{$this->_data->widgetType}_default";
            }
            return $this->$methodName($this->_data);
        } else {
            throw new Exception('widget_field data must be field_base type');
        }
    }

    /**
     * 隐藏字段
     * @param field_base $field
     * @return string 
     */
    public function field_hidden_default(field_base $field) {
        return "<input type='hidden' name='{$field->name}' value='{$field->value}' />";
    }

    /**
     * 单行文本
     * @param field_base $field
     * @return string 
     */
    public function field_text_default(field_base $field) {
        return "<label>{$field->label}<input type='text' name={$field->name} value='{$field->value}'><label class='tip' name='{$field->name}'></label></label>";
    }
    
    /**
     * 自动完成输入文本框
     * @param field_base $field
     * @return string 
     */
    public function field_text_autocomplete(field_base $field){
        //@todo goodzsq 自动完成文本框
        return '自动完成字段尚未实现';
    }

    /**
     * 下拉列表
     * @param field_base $field
     * @return string
     */
    public function field_list_default(field_base $field) {
        $buf = "<label>{$field->label}\n  <select name='{$field->name}'>\n";
        $buf .= "    <option></option>";
        foreach ($field->getList('dict') as $k => $v) {
            if ($k == $field->value) {
                $selected = ' selected';
            } else {
                $selected = '';
            }
            $buf .= "    <option value='{$k}'{$selected}>[$k] {$v}</option>\n";
        }
        $buf .= "  </select>\n<label class='tip' name='{$field->name}'></label></label>";
        return $buf;
    }
    
    public function field_list_level(field_base $field){
        $selector = "#{$this->_id} :input[name={$field->name}]";
        if(strpos($field->dict, '://') === false){
            $field->dict = base_url() . $field->dict;
        }
        jquery()->ajaxLevelSelect($selector, $field->dict);

        $buf = "<label>{$field->label}\n  <input type='text' name='{$field->name}' value='{$field->value}'>\n";
        $buf .= "<label class='tip' name='{$field->name}'></label></label>";
        return $buf;
    }

    /**
     * 单选按钮组
     * @param field_base $field
     * @return string 
     */
    public function field_list_radio(field_base $field) {
        $buf = "<label>{$field->label} <br />\n";
        foreach ($field->getList('dict') as $k => $v) {
            if ($k == $field->value) {
                $checked = ' checked="checked"';
            } else {
                $checked = '';
            }
            $buf .= "<label><input type='radio' name='{$field->name}' value='{$k}'{$checked} />{$v}</label> \n";
        }
        $buf .= "<label class='tip' name='{$field->name}'></label>";
        return $buf;
    }

    /**
     * 密码字段
     * @param field_base $field
     * @return string 
     */
    public function field_password_default(field_base $field) {
        return "<label>{$field->label}<input type='password' name={$field->name} value='{$field->value}'><label class='tip' name='{$field->name}'></label></label>";
    }

    /**
     * 多行文本默认输入
     * @param field_base $field
     * @return string 
     */
    public function field_textarea_default(field_base $field) {
        return "<label>{$field->label}<textarea name='{$field->name}'>{$field->value}</textarea><label class='tip' name='{$field->name}'></label></label>";
    }

    /**
     * 多行文本tinymce编辑器
     * @param field_base $field
     * @return type 
     */
    public function field_textarea_tinymce(field_base $field) {
        $selector = "#{$this->_id} :input[name={$field->name}]";
        jquery()->tinymce($selector);
        return $this->field_textarea_default($field);
    }
    
    public function field_file_default(field_base $field){
        $selector = "#{$this->_id} :input[name={$field->name}]";
        jquery()->uploadify($selector, $field->upload);
        return "<label>{$field->label}<input type='file' id='{$field->name}' name='{$field->name}'><label class='tip' name='{$field->name}' /></label></label>";
        
    }

}

