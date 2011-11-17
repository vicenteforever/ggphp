<?php

class field_str extends field_object {

	public $type = 'varchar';
	public $length = 255;

	function isValidFormat($value){
		if(strlen($value)> $this->length){
			$this->error = "{$this->label} must little then {$this->length}";
			return false;
		}
		return true;
	}

}
