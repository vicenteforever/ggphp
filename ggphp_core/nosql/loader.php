<?php

class nosql_loader{

    /**
     * nosql loader
     * @param string $type
     * @param string $group
     * @return nosql_adapter 
     */
    static function load($type, $group){
	$adapter = "nosql_{$type}_adapter";
	return new $adapter($group);
    }

}