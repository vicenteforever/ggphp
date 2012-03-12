<?php

class field_text_type extends field_base {

	public $type = 'text';

	function validate($value){
		return parent::validate($value);
	}

	public function widget_input($value){
		return "<label>{$this->label}<textarea name=\"{$this->name}\">{$value}</textarea></label>";
	}

}
