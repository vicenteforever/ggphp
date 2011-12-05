<?php

class structure_controller{

	function doIndex(){
		return html('structure 数据结构管理模块');
	}

	function doTest(){
		$test = new structure_schema('test');
		$test->addField('id', 'string', 'ID');
		$test->addField('name', 'string', '名称', array('length'=>5));
		return html(printr(array_keys($test->field())));
	
	}
}