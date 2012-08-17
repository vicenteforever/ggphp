<?php

/**
 * 所有字段类型的基类
 * @package field
 * @author goodzsq@gmail.com
 */
abstract class field_type_base {

    public $name;
    public $label;
    public $type = 'string';
    public $length = null;
    public $unsigned = false;
    public $allowNull = false;
    public $required = false;
    public $default = null;
    public $index = null;
    public $serial = false;
    public $number = 1;
    public $hidden = false;
    public $widget = 'string';
    public $validators = array();

    public function __construct(array $arr) {
        foreach ($arr as $k => $v) {
            $this->$k = $v;
        }
        if (empty($this->name)) {
            throw new Exception('field name not assign');
        }
        if (!isset($this->label)) {
            $this->label = $this->name;
        }

        //不必须填写的字符串并且没设默认值的=>[设置为空串]
        if ($this->type == 'string' && !$this->required && $this->default === null) {
            $this->default = '';
        }
    }

    /**
     * 读取未设置属性时返回空值，用于屏蔽错误消息
     * @param string $name
     * @return null 
     */
    public function __get($name) {
        return null;
    }

    /**
     * 字段校验
     * @param mixed $value
     * @return mixed 校验通过返回true 校验失败返回错误消息字符串 
     */
    public function validate($value) {
        if ($this->required && empty($value)) {
            return "{$this->label}必须填写";
        }
        foreach ($this->validators as $rule) {
            $validator = validator($rule);
            if (empty($validator)) {
                return "校验器{$rule}不存在";
            }
            $err = $validator->validate($this, $value);
            if ($err !== true) {
                return $err;
            }
        }
        return true;
    }

    public function toArray() {
        $result = array();
        foreach ($this as $key => $value) {
            $result[$key] = $value;
        }
        return $result;
    }

}