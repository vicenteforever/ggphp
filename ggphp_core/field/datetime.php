<?php

class field_datetime extends field_object {

	public $type = 'datetime';
	public $length = null;

	function isValidFormat($value){
		@list($date, $time) = explode(' ', trim($value));
		//判断日期
		if(!preg_match("/^(\d{4})-?(\d{1,2})-?(\d{1,2})$/", $date, $match)){
			$this->error = "{$this->label} 非法的日期";
			return false;
		}
		else if(!checkdate($match[2], $match[3], $match[1])){
			$this->error = "{$this->label} 非法的日期";
			return false;
		}
		//判断时间
		if(isset($time)){
			if(!preg_match("/^(\d{1,2}):(\d{1,2}):(\d{1,2})$/", $time, $match)){
				$this->error = "{$this->label} 非法的时间格式";
				return false;
			}
			else if($match[1]>23 || $match[2]>60 || $match[3]>60){
				$this->error = "{$this->label} 非法的时间";
				return false;
			}
		}
		return true;
	}

}
