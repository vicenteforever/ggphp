<?php

class image_controller {

	function doIndex(){
		return html('image 图像处理模块');
	}
	
	function doDoc(){
		return html(view('document'));
	}

	function doCache(){
		$path = path();
		if(preg_match("/\.\.|[\:\\\\]/", $path)) error('url error');
		if(preg_match("/cache\/(.*)\/(.*\.(png|jpg|gif|jpeg|bmp)$)/iU", $path, $match)){
			$image = image_loader::load();
			$savepath =  APP_DIR.DS.str_replace('/', DS, $path);
			$style = $match[1];
			$config = config('imagestyle', $style);
			foreach($config as $k=>$v){
				$image->$k = $v;
			}
			$src = str_replace('/', DS, APP_DIR.DS.$match[2]);
			if(is_file($src)){
				$image->Thumblocation = dirname($savepath).DS;
				$image->Thumbfilename = basename($savepath);
				if(!is_dir($image->Thumblocation)){
					mkdir($image->Thumblocation, 0700, true);
				}
				$image->createThumb($src, 'file');
			}
			else{
				echo 'file no found'.$src;
			}
		}
	}

	function doCaptcha(){
		include(dirname(__FILE__).DS."captcha.php");
	}

}