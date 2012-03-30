<?php

/**
 * 文件上传组件
 * @package widget_field
 * @author goodzsq@gmail.com
 */
class widget_field_file {

    /**
     * uploadify多文件上传组件
     * @param field_base $field
     * @return type 
     */
    public function style_default(field_base $field){
        if(empty($field->value)){
            $field->value = util_string::token();
        }
        $selector = ":input[name={$field->name}]";
        $params = array('token'=>$field->value);
        jquery_plugin()->uploadify($selector, abs_url($field->uploadurl), $params);
        return "<label>{$field->label}<input type='hidden' id='{$field->name}' name='{$field->name}' value='{$field->value}'><label class='tip' name='{$field->name}' /></label></label>";        
    }

}

