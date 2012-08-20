<?php

/**
 * 图片验证码校验
 * @package field
 * @author $goodzsq@gmail.com
 */
class field_type_captcha extends field_type_base {

    public $widget = 'captcha';
    public $isDatabase = false;

    public function validate($value) {
        return image_captcha::validate($value);
    }

}