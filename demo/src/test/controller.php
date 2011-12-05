<?php

class test_controller{

	function doIndex(){
		return html('ggphp examples');
	}

	function doTest(){
		return html('test');
	}

	function doConfig(){
		$appname = 'read from config file <br> app_name is:'.config('app', 'app_name');
		return html($appname, '读取配置文件测试');
	}

	function doTranslate(){
		return html(t('hello world'), '翻译测试');
	}

	function doStructure(){
		$group = new structure_model('group');
		$group->addField('id', 'string', 'ID', array('primary'=>true));
		$group->addField('name', 'string', '名称');
	}

}