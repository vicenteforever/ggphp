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

    protected function html(orm_helper $helper) {
        $buf = "<form method=\"POST\" id=\"{$this->_id}\" action=\"$helper->url\">\n";
        foreach ($helper->fields() as $k => $field) {
            $field->value = $helper->fieldValue($k, $helper->entity);
            $buf .= widget('field', $this->_id, $field)->render() . " </br>\n";
        }

        $buf .= "<input type=submit />";

        $buf .= "</form>";
        return $buf;
    }

}
