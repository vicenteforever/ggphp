<?php

class test_controller{

	function doIndex(){
		return html('ggphp examples');
	}

	function doTest(){
		return html('unit test');
	}

	function doConfig(){
		$appname = 'read from config file <br> app_name is:'.config('app', 'app_name');
		return html($appname, 'read config file test');
	}

	function doTranslate(){
		return html(t('hello world'), 'translate test');
	}

	function doSmarty(){
		$smarty = core_view::smarty();
		$smarty->assign('name', 'hello world');
		$smarty->display('index.tpl');
	}

}