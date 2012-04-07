<?php

/**
 * 查询语句构造
 * @package query
 * @author goodzsq@gmail.com
 */
class orm_query {
    
    private $_source;
    private $_fields;
    
    public function __construct($source) {
        $this->_source = $source;
    }
    
    public function select($fields=null){
        if(isset($fields)){
            $this->_fields = $fields;
        }
        else{
            $this->_fields = '*';
        }
    }
    
    public function fields(){
        return $this->_fields;
    }
    
    public function source(){
        return $this->_source;
    }
}

