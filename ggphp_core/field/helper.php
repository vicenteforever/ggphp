<?php

class field_helper{

	static function fields(){
		$core_field = util_file::subdir(GG_DIR.DS.'field');
		$app_field = util_file::subdir(APP_DIR.DS.'field');
		return array_merge($core_field, $app_field);
	}

	static function widget($field){
		$result = array();
		$fieldName = "field_{$field}_type";
		$methods = get_class_methods($fieldName);
		if(is_array($methods)){
			foreach($methods as $method){
				if(strpos($method, 'widget_') === 0){
					$result[] = $method;
				}
			}
		}
		return $result;
	}
}