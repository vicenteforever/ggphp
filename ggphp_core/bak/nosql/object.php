<?php

/**
 * nosql键值存储对象抽象类
 * @package nosql
 * @author goodzsq@gmail.com
 * 文件存储
 */
abstract class nosql_object {

    protected $_data;
    protected $_source;

    function __construct($source) {
        $this->_source = $source;
        $this->load();
    }

    function __get($name) {
        if(isset($this->_data[$name])){
            return $this->_data[$name];
        }
        else{
            return null;
        }
    }
    
    function __set($name, $value) {
        $this->_data[$name] = $value;
    }
    
    function __toString() {
        return __CLASS__;
    }
    
    /**
     * 灌入或者返回所有数据
     * @param array $data
     * @return array 
     */
    function data($data=null){
        if(isset($data)){
            $this->_data = $data;
        }
        else{
            return $this->_data;
        }
    }

    /**
     * 将数据转存为其他存储数据源，例如将文件数据源另存为memcached数据源
     * @param nosql_object $object 
     */
    function saveAs(nosql_object $object){
        $object->data($this->_data);
        $object->save();
    }
    
    /**
     * 从数据源载入数据
     */
    abstract function load();

    /**
     * 将数据存入数据源
     */
    abstract function save();
    
    /**
     * 删除数据源
     */
    abstract function delete();
    
}