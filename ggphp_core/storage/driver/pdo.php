<?php

/**
 * @author goodzsq@gmail.com
 * 数据库存储适配器
 */
class storage_driver_pdo{

	private $_db;
	private $_tablename;
	private $_insert;
	private $_update;
	private $_delete;
	private $_select;

	function __construct($group){
		if(empty($server)){
			$server = 'default';
		}
		$this->_tablename = $group;
		$this->_db = pdo($server);
		$this->_update = $this->_db->prepare("UPDATE `{$this->_tablename}` SET `value`=:value WHERE `key`=:key");
		$this->_insert = $this->_db->prepare("INSERT INTO `{$this->_tablename}` (`key`, `value`) VALUES (:key, :value)");
		$this->_delete = $this->_db->prepare("DELETE FROM `{$this->_tablename}` WHERE `key`=:key");
		$this->_select = $this->_db->prepare("SELECT * FROM `{$this->_tablename}` WHERE `key`=:key");
	}

	function load($key){
		$this->_select->bindParam(':key', $key);
		$rs = $this->_select->execute();
		if($row=$this->_select->fetch()){
			return unserialize($row['value']);
		}
		return null;
	}

	function save($key, $data){
		$value = serialize($data);
		$this->_update->bindParam(':key', $key);
		$this->_update->bindParam(':value', $value);
		$this->_update->execute();
		if($this->_update->rowCount()==0){
			$this->_insert->bindParam(':key', $key);
			$this->_insert->bindParam(':value', $value);
			$this->_insert->execute();
		}
	}

	function delete($key){
		$this->_delete->bindParam(':key', $key);
		$this->_delete->execute();
	}
}