<?php

class module_image_controller {

	function doIndex(){
		return GG_Response::redirect('doc');
	}
	
	function doDoc(){
		return GG_Response::html('图像模块', view('document'));
	}

	function doCache(){
		$path = path();
		if(preg_match("/\.\.|[\:\\\\]/", $path)) error('url error');
		if(preg_match("/cache\/(.*)\/(.*\.(png|jpg|gif|jpeg|bmp)$)/iU", $path, $match)){
			$image = module_image_loader::load();
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