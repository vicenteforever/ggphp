<?php

class test_controller {

	function doIndex() {
		return html('ggphp examples');
	}

	function doPhpinfo() {
		phpinfo();
	}

	function doFilter() {
		$str =  'h1. hello <a href=javascript:alert(123)>world</a>';
		return html(output($str, array('xss', 'textile')));
	}

	function doConfig() {
		$appname = 'read from config file <br> app_name is:' . config('app', 'app_name');
		return html($appname, 'read config file test');
	}

	function doTranslate() {
		return html(t('hello world'), 'translate test');
	}

	function doSmarty() {
		$smarty = core_view::smarty();
		$smarty->assign('name', 'hello world');
		$smarty->display('index.tpl');
	}

	function doTextile() {
		$in = <<<EOF
h2. textile filter sample
    
A *simple* example.

EOF;
		return html(util_filter::textile($in));
	}

}