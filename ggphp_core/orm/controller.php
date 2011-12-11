<?php

class orm_controller{

	function doIndex(){
		return html('ORM data mapper');
	}

	function doTest(){
		$mapper = new orm_mapper('user');
		$t = $mapper->all();
		$buf = '';
		//foreach($t as $row){
		//	$buf .= print_r($row, true);
		//}
		$buf = print_r($mapper->first(), true);
		$buf .= $mapper->debug();
		return html($buf);
	
	}
}