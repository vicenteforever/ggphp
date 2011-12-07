<?php

class structure_controller{

	function doIndex(){
		return html('structure 数据结构管理模块');
	}

	function doTest(){
		$mapper = new structure_mapper('user');
		$t = $mapper->all();
		foreach($t->next()){
			print_r(t);
			
		}
		
	
	}
}