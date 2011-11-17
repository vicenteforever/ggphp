<?php

class model_video extends model_directory{

	private $_fileType = array('mkv', 'mp4', 'avi', 'rm', 'rmvb', 'mpg', 'vob');

	function isTypeFile($f){
		if(is_dir($f)){
			$tmp = explode(DS, trim($f, DS));
			$basename = end($tmp);
			if (preg_match("/^A\d{5}$/i", $basename))
				return true;
			else
				return false;
		}
		else{
			return in_array(util_filename::file_ext($f), $this->_fileType);
		}
	}

	function getRootDir(){
		return gbk("I:\\最新电影");
	}

}