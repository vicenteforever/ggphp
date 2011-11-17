<?php

class controller_default {

	function doIndex(){
		echo 'image application';
	}

	function doCache(){
		$path = path();
		if(preg_match("/\.\.|[\:\\\\]/", $path)) exit('error');
		if(preg_match("/cache\/(.*)\/(.*\.(png|jpg|gif|jpeg|bmp)$)/iU", $path, $match)){
			$image = include_once(APP_DIR.DS."lib".DS."image.php");
			$savepath =  APP_DIR.DS.str_replace('/', DS, $path);
			$style = $match[1];
			$config = config('imagestyle', $style);
			foreach($config as $k=>$v){
				$image->$k = $v;
			}
			$file = str_replace('/', DS, dirname(APP_DIR).DS.$match[2]);
			if(is_file($file)){
				$image->Thumblocation = dirname($savepath).DS;
				$image->Thumbfilename = basename($savepath);
				if(!is_dir($image->Thumblocation)){
					mkdir($image->Thumblocation, 0700, true);
				}
				$image->createThumb($file, 'file');
			}
			else{
				echo 'nofile';
			}
		}
	}

	function doCaptcha(){
		include(APP_DIR.DS."lib".DS."captcha.php");
	}

}