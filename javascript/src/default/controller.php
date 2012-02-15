<?php

class default_controller{

	function do_index(){
		echo 'default controller';
	}

	function do_compress(){
		$url = param('url');
		$newname = param('newname');
		if(empty($url)) error('url not assign');
		if( substr($url, 0, 7) == 'http://' ||
			substr($url, 0, 8) == 'https://' ||
			substr($url, 0, 6) == 'ftp://'){
			if($content=file_get_contents($url)){
				$content = gzencode($content);
				if(empty($newname)) {
					$newname = util_string::token();
				}
				else{
					//filter invalid character
					$newname = preg_replace("/[\W]/", '_', $newname);
				}
				$newname .= '.zip';
				$filename = APP_DIR.DS.$newname;
				if(file_exists($filename)) error('file already exists');
				file_put_contents($filename, $content);
				echo "compress complete to file:$newname";
			}
			else{
				echo "Cannot read from $url";
			}
		}
		else{
			error('invalid url:'. $url);
		}
	}
}