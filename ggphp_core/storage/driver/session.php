<?php

/**
 * @author goodzsq@gmail.com
 * session存储适配器器
 */
class storage_driver_session{

	private $_group;

	function __construct($group){
		$this->_group = $group;
		use_session();
	}

	function load($key){
		if(isset($_SESSION[$this->_group][$key])){
			return unserialize($_SESSION[$this->_group][$key]);
		}
		return null;
	}

	function save($key, $data){
		$_SESSION[$this->_group][$key] = serialize($data);
	}

	function delete($key){
		unset($_SESSION[$this->_group][$key]);
	}
}