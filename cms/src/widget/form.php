<?php

/**
 * form
 * @package widget
 * @author goodzsq@gmail.com
 */
class widget_form extends widget_base {

    public function __construct($id, $data) {
        parent::__construct($id, $data);
        $this->_id = "form_$id";
    }

    public function theme_default() {
        if ($this->_data instanceof orm_helper) {
            jquery()->ajaxSubmit('#' . $this->_id);
            return $this->html($this->_data);
        }
    }

    private function html(orm_helper $helper) {
        $buf = "<form method=\"POST\" id=\"{$this->_id}\" action=\"$helper->url\">\n";
        foreach ($helper->field() as $k => $field) {
            $value = $helper->fieldValue($k, $helper->entity);
            if ($field->hidden || $field->field == 'id') {
                $buf .= $this->fieldHidden($field, $value) . "\n";
            } else {
                if($field->required){
                    $required = '*';
                }
                else{
                    $required = '';
                }
                if ($field->field == 'text') {
                    $buf .= $this->fieldTextArea($field, $value) . "$required<br /> \n";
                } else {
                    $buf .= $this->fieldText($field, $value) . "$required<br /> \n";
                }
                //rebuild jquery widget
                if (!empty($field->widget)) {
                    $methodName = 'widget_text_' . $field->widget;
                    if (method_exists(jquery(), $methodName)) {
                        $selector = "#{$this->_id} :input[name={$field->name}]";
                        jquery()->$methodName($selector);
                    }
                }
                //end jquery widget
            }
        }
        $buf .= "<input type=submit />";

        $buf .= "</form>";
        return $buf;
    }

    /**
     *创建隐藏字段
     * @param field_base $field
     * @return string 
     */
    private function fieldHidden(field_base $field, $value) {
        return "<input type='hidden' name='{$field->name}' value='{$value}' />";
    }

    /**
     * 创建单行文本
     * @param field_base $field
     * @param string $value
     * @return string 
     */
    private function fieldText(field_base $field, $value) {  
        return "<label>{$field->label}<input type='text' name={$field->name} value='{$value}'><label class='tip' name='{$field->name}'></label></label>";
    }

    /**
     * 创建多行文本
     * @param field_base $field
     * @param string $value
     * @return string 
     */
    private function fieldTextArea(field_base $field, $value) {
        return "<label>{$field->label}<textarea name='{$field->name}'>{$value}</textarea><label class='tip' name='{$field->name}'></label></label>";
    }

}
