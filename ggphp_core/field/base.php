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

    function __construct(array $arr) {
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

    function __get($name) {
        return null;
    }

}
