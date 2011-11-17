<?php

/**
 * @author goodzsq@gmail.com
 * 文件存储适配器器
 */
class storage_adapter_file{

	private $_dir;
	function __construct($dir){
		$this->_dir = APP_DIR.DS.'storage'.DS.'file'.DS.$dir;
	}

	function load($key){
		$filename = $this->getFilename($key);
		if (file_exists($filename)){
			return unserialize(file_get_contents($filename));
		}
		return null;
	}

	function save($key, $data){
		$filename = $this->getFilename($key);
		if(!is_dir($this->_dir)){
			mkdir($this->_dir, 0700, true);
		}
		$buf = serialize($data);
		$fp = fopen($filename, 'w');
		flock($fp, LOCK_EX);
		fputs($fp, $buf);
		flock($fp, LOCK_UN);
		fclose($fp);
	}

	function delete($key){
		$filename = $this->getFilename($key);
		if(file_exists($filename)){
			unlink($filename);
		}
	}

	private function getFilename($key){
		$key = preg_replace("/\W/", '_', $key);
		return $this->_dir.DS.$key.'.txt';
	}
}