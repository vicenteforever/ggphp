<?php

class model_music extends model_directory{

	private $_fileType = array('mp3', 'ape', 'flac', 'wav', 'ogg');

	function isTypeFile($f){
		return in_array(util_filename::file_ext($f), $this->_fileType);
	}

	function getRootDir(){
		return "E:\\music";
	}

}