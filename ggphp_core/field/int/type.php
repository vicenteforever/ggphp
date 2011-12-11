<?php

class field_int_type extends field_base {

	public $type = 'int';
	public $length = 11;

	function validate($value){
		$value2 = (int)$value.'';
		if($value!=$value2){
			return "{$this->label} is not integer";
		}
		return parent::validate($value);
	}

	public function widget_input($value){
		return "<label>{$this->label}</label> <input type=\"text\" name=\"{$this->name}\" value=\"{$value}\" />";
	}
}
