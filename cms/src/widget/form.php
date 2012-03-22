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

    /**
     * 用ajax提交和校验的窗体
     * @return type 
     */
    public function theme_default() {
        if ($this->_data instanceof orm_helper) {
            jquery()->ajaxSubmit('#' . $this->_id);
            return $this->html($this->_data, false);
        }
    }

    /**
     * 用ajax提交和校验的窗体,附带验证码校验
     * @return string 
     */
    public function theme_captcha() {
        if ($this->_data instanceof orm_helper) {
            jquery()->ajaxSubmit('#' . $this->_id);
            return $this->html($this->_data, true);
        }
    }

    /**
     * 验证码
     * @return string 
     */
    protected function captcha() {
        $url = base_url() . 'image/captcha';
        return "<input type='text' name='captcha'><img id='captcha' src='$url' />\n";
    }

    protected function html(orm_helper $helper, $captcha) {
        $buf = "";
        $enctype = '';
        foreach ($helper->fields() as $k => $field) {
            if($field instanceof field_file){
                $enctype = ' enctype="multipart/form-data"';
            }
            $field->value = $helper->fieldValue($k, $helper->entity);
            $buf .= widget('field', $this->_id, $field)->render() . " </br>\n";
        }
        if ($captcha) {
            $buf .= $this->captcha();
        }
        $buf .= "<input type='hidden' name='" . util_csrf::key() . "' value='" . util_csrf::token() . "' />";
        $buf .= "<input type=submit />";
        $result = "<form method=\"POST\" id=\"{$this->_id}\" action=\"$helper->url\"{$enctype}>\n{$buf}\n</form>";
        return $result;
    }

}
