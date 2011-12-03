<?php

class field_int extends field_object {

	public $type = 'int';
	public $length = 11;

	function isValidFormat($value){
		$value2 = (int)$value.'';

		if($value!=$value2){
			$this->error = "{$this->label}����Ϊ��������";
			return false;
		}
		return true;
	}

}
