<?php

class field_datetime extends field_type {

	public $type = 'datetime';
	public $length = null;
        public $defaultWidget = 'text';

	function validate($value){
		@list($date, $time) = explode(' ', trim($value));
		//判断日期
		if(!preg_match("/^(\d{4})-?(\d{1,2})-?(\d{1,2})$/", $date, $match)){
			return "非法的日期";
		}
		else if(!checkdate($match[2], $match[3], $match[1])){
			return "非法的日期";
		}
		//判断时间
		if(isset($time)){
			if(!preg_match("/^(\d{1,2}):(\d{1,2}):(\d{1,2})$/", $time, $match)){
				return "非法的时间格式";
			}
			else if($match[1]>23 || $match[2]>60 || $match[3]>60){
				return "非法的时间";
			}
		}
		return true;
	}


}
