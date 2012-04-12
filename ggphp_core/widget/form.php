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
        jquery_plugin()->ajaxSubmit('#' . $this->_id);
        return $this->html($this->_data, false);
    }

    /**
     * 用ajax提交和校验的窗体,附带验证码校验
     * @return string 
     */
    public function theme_captcha() {
        jquery_plugin()->ajaxSubmit('#' . $this->_id);
        return $this->html($this->_data, true);
    }

    /**
     * 验证码
     * @return string 
     */
    protected function captcha() {
        $url = base_url() . 'image/captcha';
        return "<input type='text' name='captcha'><img id='captcha' src='$url' />\n";
    }

    protected function html(orm_entity $entity, $captcha=null) {
        $buf = "";
        $enctype = '';
        //$enctype = ' enctype="multipart/form-data"';
        $csrfToken = util_csrf::token();
        $fieldset = $entity->model()->fieldset();
        /* @var $field field_base */
        foreach ($fieldset->fields() as $k => $field) {
            $field->setValue($entity->$k);
            if ($field->required) {
                $required = ' *';
            } else {
                $required = '';
            }
            //$buf .= widget('field', $this->_id, $field)->render() . "$required <br />\n";
            $buf .= $field->widget() . "$required <br />\n";
        }
        if ($captcha) {
            $buf .= $this->captcha();
        }
        $buf .= "<input type='hidden' name='" . util_csrf::key() . "' value='$csrfToken' />";
        $buf .= "<input type=submit />";
        $result = "<form method=\"POST\" id=\"{$this->_id}\" action=\"$fieldset->url\"{$enctype}>\n{$buf}\n</form>";
        return $result;
    }

}
