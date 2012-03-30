<?php

abstract class field_base {

    public $name;
    public $label;
    public $type = 'string';
    public $length = 255;
    public $required = false;
    public $number = 1;
    public $hidden = false;
    public $widgetType = 'string';
    public $widgetStyle = 'default';
    public $default = null;
    public $value;
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

        //不必须填写的字符串 没设默认值的 [设置为空串]
        if ($this->type == 'string' && !$this->required && $this->default === null) {
            $this->default = '';
        }
    }

    /**
     * 返回字段可选的值列表
     * @param string $source
     * @return array 
     */
    public function getList($source) {
        return array();
    }

    /**
     * 读取字段的值，如果未设置返回字段默认值
     * @return mixed 
     */
    public function getValue() {
        if ($this->value === null) {
            return $this->default;
        }
        return $this->value;
    }

    /**
     * 设置字段的值
     * @param mixed $value 
     */
    public function setValue($value) {
        $this->value = $value;
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
     * @return mixed 校验通过返回true 校验失败返回错误消息字符串 
     */
    public function validate() {
        if ($this->required && empty($this->value)) {
            return "{$this->label}必须填写";
        }
        foreach ($this->validators as $key => $rule) {
            $validator = validator($rule);
                    //var_dump($validator);
            if(empty($validator)){
                return "校验器{$rule}不存在";
            }
            $err = $validator->validate($this);
            if ($err !== true) {
                return $err;
            }
        }
        return true;
    }
    
    public function widget(){
        $className = "widget_field_{$this->widgetType}";
        $methodName = "style_{$this->widgetStyle}";
        try{
            if(class_exists($className)){
                return call_user_func(array($className, $methodName), $this);
            }
            else{
                return "$className 不存在";
            }
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

}