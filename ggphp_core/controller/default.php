<?php

class controller_default {

	function doIndex(){
		$data['title'] = '欢迎使用GGPhp!';
		$data['content'] = '请在'.APP_DIR.DS.'controller'.DS.'下建立属于您自己的控制器';
		echo view('html', $data);
	}
}