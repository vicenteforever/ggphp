<?php

class field_controller{

	function doIndex(){
		return html('字段管理');
	}

	function doAdmin(){
		$result = array();
		$fields = field_helper::fields();
		foreach($fields as $field=>$path){
			$result[$field] = field_helper::widget($field);
		}
		return html(trace($result));
	}

}