<?php

class field_controller{

	function do_index(){
		return html('字段管理');
	}

	function do_admin(){
		$result = array();
		$fields = field_helper::fields();
		foreach($fields as $field=>$path){
			$result[$field] = field_helper::widget($field);
		}
		return html(trace($result));
	}

}