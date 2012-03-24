<?php

abstract class field_base {

    abstract function validate($value);

    public $name;
    public $label;
    public $type = 'string';
    public $length = 255;
    public $required = false;
    public $number = 1;
    public $hidden = false;
    public $widgetType = 'text';

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
    }

    /**
     * 返回字段可选的值列表
     * @param string $source
     * @return array 
     */
    public function getList($source){
        return array();
    }
    
    /**
     * 读取未设置属性时返回空值,屏蔽警告错误
     * @param string $name
     * @return null 
     */
    public function __get($name) {
        return null;
    }

}