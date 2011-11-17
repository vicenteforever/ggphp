<?php

/**
 * @author goodzsq@gmail.com
 * memcache存储适配器器
 */
class storage_adapter_memcache{

	private $_memcache;

	function __construct($group){
		$this->_memcache = memcache($group);
	}

	function load($key){
		if($data = $this->_memcache->get($key)){
			return $data;
		}
		else{
			return null;
		}
	}

	function save($key, $data){
		$this->_memcache->set($key, $data);
	}

	function delete($key){
		$this->_memcache->delete($key);
	}
}