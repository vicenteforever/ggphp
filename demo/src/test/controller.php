<?php

class test_controller{

	function doIndex(){
		return html('ggphp examples');
	}

	function doTest(){
		$mapper = new structure_mapper('user');
		$entity = $mapper->get();
		$entity->name = 'sdf';
		$mapper->save($entity);
		$result = printr($mapper->errors());
		return html($mapper->helper()->form('save', $entity));
	}

	function doConfig(){
		$appname = 'read from config file <br> app_name is:'.config('app', 'app_name');
		return html($appname, 'read config file test');
	}

	function doTranslate(){
		return html(t('hello world'), 'translate test');
	}

}