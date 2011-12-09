<?php

class field_file extends field_object {

	public $type = 'varchar';
	public $length = 255;

	function isValidFormat($value){
		$pos = strpos($value, '..');
		if($pos!==false){
			$this->error = "{$this->label}文件名中含有非法的字符";
			return false;
		}
		return true;
	}

}
