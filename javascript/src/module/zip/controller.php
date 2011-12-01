<?php

class module_zip_controller{

	function doIndex(){
		echo 'zip controller';
	}

	function doJquery(){
		$filename = APP_DIR.DS.'jquery-1.7.1.min.zip';
		$content = file_get_contents($filename);
		echo GG_Response::gzip($content, 'text/javascript');
	}
}