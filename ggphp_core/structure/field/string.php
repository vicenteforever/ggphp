<?php

class structure_field_string {

	public $type = 'varchar';
	public $length = 255;
	public $name;
	public $label;
	public $required=false;
	public $number=1;
	public $index;

	function check($value){
		if(strlen($value)> $this->length){
			return "{$this->label} must little then {$this->length}";
		}
		return true;
	}

}
