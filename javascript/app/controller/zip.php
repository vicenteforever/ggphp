<?php

class controller_zip{

	function doIndex(){
		echo 'javascript zip';
	}

	function doJquery(){
		$filename = APP_DIR.DS.'test.zip';
		$content = file_get_contents($filename);
		echo GG_Response::gzip($content, 'text/javascript');
	}
}