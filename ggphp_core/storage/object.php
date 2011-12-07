<?php

class storage_object{

	private $_driver;
	private $_schema;

	/**
	 * @param string $driver
	 * @param string $schema
	 */
	function __construct($driver, $schema){
		$driverName = 'storage_driver_'.$driver;
		$schemaName = 'structure_schema';
		$this->_driver = new $driverName($schema);
		$this->_schema = new $schemaName($schema);
	}

	function field(){
		return $this->_schema->field();
	}

	function create(){
	
	}

	function retrieve($key=null){
	
	}

	function update(){
	
	}

	function delete(){
	
	}
}