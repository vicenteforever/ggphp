<?php

class orm_controller{

	function do_index(){
		return 'ORM data mapper';
	}

	function do_test(){
		$mapper = new orm_mapper('user');
		$t = $mapper->all();
		$buf = '';
		//foreach($t as $row){
		//	$buf .= print_r($row, true);
		//}
		$buf = print_r($mapper->first(), true);
		$buf .= $mapper->debug();
		return $buf;
	
	}
}