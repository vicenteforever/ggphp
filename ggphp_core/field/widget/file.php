<?php

/**
 * 文件上传组件
 * @package widget_field
 * @author goodzsq@gmail.com
 */
class field_widget_file {

    /**
     * uploadify多文件上传组件
     * @param field_type_base $field
     * @return type 
     */
    public function style_default(field_type_base $field, $value){
        if(empty($value)){
            $value = util_string::token();
        }
        $selector = ":input[name={$field->name}]";
        $params = array('token'=>$value);
        jquery_plugin()->uploadify($selector, abs_url($field->uploadurl), $params);
        return "<label>{$field->label}<input type='hidden' id='{$field->name}' name='{$field->name}' value='{$value}'><label class='tip' name='{$field->name}' /></label></label>";        
    }

}

