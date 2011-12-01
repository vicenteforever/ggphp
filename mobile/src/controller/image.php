<?php

class controller_image {

	function doIndex(){
		echo 'image application';
	}

	function doCover(){
		$style = param(0);
		$id = param(1);
		$rs = pdo()->query("select * from video where id='$id'");
		if($row = $rs->fetch()){
			$src = gbk($row['dir']).DS.'a1.jpg';
			if(file_exists($src)){
				$image = lib_image::load();
				$savepath =  APP_DIR.DS.'cover'.DS.$style.DS.$id.'.jpg';
				$config = config('imagestyle', $style);
				foreach($config as $k=>$v){
					$image->$k = $v;
				}
				$image->Thumblocation = dirname($savepath).DS;
				$image->Thumbfilename = basename($savepath);
				if(!is_dir($image->Thumblocation)){
					mkdir($image->Thumblocation, 0700, true);
				}
				$image->createThumb($src, 'file');
				header('Content-type: image/jpeg');
				echo file_get_contents($savepath);
			}
			else{
				header('Content-type: image/png');
				echo file_get_contents(APP_DIR.DS.'images'.DS.'movie.png');
			}
		}
	}

}