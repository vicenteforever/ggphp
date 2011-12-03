<?php

class field_password extends field_object {

	public $type = 'varchar';
	public $length = 255;

	function isValidFormat($value){
		if(!array($value) || count($value)!=2){
			$this->error = '密码赋值格式错误 $object->password->value=array("新密码","新密码确认")';
			return false;
		}
		else if($value[0]!=$value[1]){
			$this->error = "密码设置错误";
			return false;
		}
		return true;
	}

	function getValue(){
		$value = parent::getValue();
		return $value[0];
	}

}
