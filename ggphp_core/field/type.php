<?php

class field_type {
	public $name;
	public $label;
	public $type = 'string';
	public $length = 255;
	public $required = false;
	public $number = 1;
	public $hidden = false;

	function __construct(array $arr){
		foreach($arr as $k=>$v){
			$this->$k = $v;
		}
		if(empty($this->name)){
			throw new Exception('field name not assign');
		}
		if(!isset($this->label)){
			$this->label = $this->name;
		}
	}

	/**
	 * 值校验检查
	 */
	function validate($value){
		if($this->required && !isset($value)){
			return "{$this->name} is required";
		}
		return true;
	}

	/**
	 * 生成widget部件的html
	 */
	function widget($value='') {
		$method = 'widget_'.$this->widget;
		if(method_exists($this, $method)){
			return $this->$method($value);
		}
		else{
			return $value;
		}
	}

	/**
	 * 生成widget部件的html
	 */
	function widget_input_hidden($value='') {
		return "<input type=\"hidden\" name=\"{$this->name}\" value=\"{$value}\" />";
	}
	
	function __get($name) {
		return null;
	}
	
}
