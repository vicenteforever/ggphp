<?php

/**
 * 所有字段类型的基类
 * @package field
 * @author goodzsq@gmail.com
 */
abstract class field_type_base {

    public $name;                 //字段名称
    public $label;                //字段标签
    public $type = 'string';      //数据类型
    public $length = null;        //长度
    public $unsigned = false;     //是否为无符号整数
    public $allowNull = false;    //是否允许为空
    public $required = false;     //是否必须填写
    public $default = null;       //默认值
    public $index = null;         //是否为索引
    public $serial = false;       //自动加一
    public $widget = 'string';    //字段控件
    public $validators = array(); //字段校验器集
    public $isDatabase = true;    //是否为数据库字段
    public $isHidden = false;     //是否隐藏控件

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