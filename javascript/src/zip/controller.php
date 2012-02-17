<?php

class zip_controller{

	function index(){
		echo 'zip controller';
	}

	function jquery(){
		$filename = APP_DIR.DS.'jquery-1.7.1.min.zip';
		$content = file_get_contents($filename);
		echo core_response::gzip($content, 'text/javascript');
	}
}