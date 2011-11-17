<?php

class model_directory {

	private $_files = array();
	private $_subDirs = array();
	private $_dir = '';

	function load($dir){
		$rootdir = rtrim($this->getRootDir(), 'DS').DS;
		if(empty($dir)){
			$dir = $rootdir;
		}
		else{
			$dir = rtrim($dir, 'DS').DS;
		}

		if(util_string::is_utf8($dir)){
			$dir = gbk($dir);
		}

		if(!preg_match("/^".addslashes($rootdir)."/i", $dir)){
			error("other path not allow : ".utf8($rootdir).':'.utf8($dir));
		}
		if(preg_match("/\.\./", $dir)){
			error('.. not allow');
		}

		if(is_dir($dir)){
			$list = scandir($dir);
			foreach($list as $f){
				$path = $dir.$f;
				$info = array(
						'title'=>utf8($f), 
						'path'=>utf8($path), 
						'realpath'=>$path
					);
				if($this->isTypeFile($path)){
					$this->_files[] = $info;
				}
				else if(is_dir($path) && $f!='.' && $f!='..' && $f!='System Volume Information' && $f!='RECYCLER'){
					$this->_subDirs[] = $info;
				}
			}
		}
		else{
			//error(utf8($dir).' dir not exist');
		}
	}

	function getFiles(){
		return $this->_files;
	}

	function getSubDirs(){
		return $this->_subDirs;
	}

	function isTypeFile($f){
		return !is_dir($f);
	}

	function getRootDir(){
		return ;
	}

	function getTitle(){
		return '';
	}

}