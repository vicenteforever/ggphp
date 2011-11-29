<?php

class model_smarthome {

	private $_files = array();
	private $_subDirs = array();

	function getFiles(){
		return $this->_files;
	}

	function getSubDirs(){
		return array(
			array('title'=>'场景', 'path'=>'scene'),
			array('title'=>'影音', 'path'=>'av'),
			array('title'=>'灯光', 'path'=>'light'),
			array('title'=>'空调', 'path'=>'scene'),
		);
	}
}