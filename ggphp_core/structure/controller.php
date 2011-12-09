<?php

class structure_controller{

	function doIndex(){
		return html('structure 数据结构管理模块');
	}

	function doTest(){
		$mapper = new structure_mapper('user');
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