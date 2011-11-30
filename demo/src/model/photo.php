<?php

class model_photo extends model_directory{

	private $_fileType = array('jpg', 'png', 'gif', 'jpeg', 'bmp');

	function isTypeFile($f){
		return in_array(util_filename::file_ext($f), $this->_fileType);
	}

	function getRootDir(){
		return "f:\\pic";
	}

}