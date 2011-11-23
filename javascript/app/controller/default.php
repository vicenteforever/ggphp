<?php

class Controller_Default{

	function doIndex(){
		echo 'javascript';
	}

	function doJquery(){
		if(param('refresh')=='1'){
			$content = gzencode(file_get_contents(APP_DIR.DS.'jquery-1.7.1.min.zip'));
			$fp = fopen(APP_DIR.DS.'jquery.gzip', 'w');
			fputs($fp, $content);
			fclose($fp);
		}
		else{
			$content = file_get_contents(APP_DIR.DS.'jquery.gzip');
		}
		echo GG_Response::gzip($content);
	}


}