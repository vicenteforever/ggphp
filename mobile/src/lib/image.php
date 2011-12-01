<?php

class lib_image{

	static function load(){
		static $image;
		if(!isset($image)){
			$dir = dirname(__FILE__);
			include($dir.DS."easyphpthumbnail.class.php");
			$image = new easyphpthumbnail();
		}
		return $image;
	}
}
