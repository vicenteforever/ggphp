<?php

class module_image_loader{

	static function load(){
		static $image;
		if(!isset($image)){
			include(dirname(__FILE__).DS."easyphpthumbnail.class.php");
			$image = new easyphpthumbnail();
		}
		return $image;
	}
}