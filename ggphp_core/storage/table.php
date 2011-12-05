<?php

class storage_table{

	private $_driver;
	private $_schema;

	/**
	 * @param string $driver
	 * @param string $schema
	 */
	function __construct($driver, $schema){
		$driverName = 'storage_driver_'.$driver;
		$schemaName = 'structure_schema';
		$self->_driver = new $driverName($schema);
		$self->schema = new $schemaName($schema);
	}



}