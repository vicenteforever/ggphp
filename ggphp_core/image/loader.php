<?php

class image_loader{

	static function load(){
		static $image;
		if(!isset($image)){
			include(GG_DIR."/lib/phpthumb/easyphpthumbnail.class.php");
			$image = new easyphpthumbnail();
		}
		return $image;
	}
}