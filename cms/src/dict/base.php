<?php

/**
 * 数据字典基类
 * @package dict
 * @author goodzsq@gmail.com
 */
abstract class dict_base {
    
    protected $_data = array();

    /**
     * 从数据源获取字典数据 
     */
    abstract function loadData();

    /**
     * 保存数据字典到数据源
     */
    abstract function saveData();
    
    /**
     * 构造器，获取字典数据 
     */
    public function __construct() {
        $this->_data = $this->loadData();
        if(!is_array($this->_data)){
            throw new Exception('dict load data fail');
        }
    }
    
    /**
     * 获取字典所有键值
     * @return array 
     */
    public function getKeys(){
        return array_keys($this->_data);
    }
    
    /**
     * 获取字典某键对应的值
     * @param string $key
     * @return string 
     */
    public function getValue($key){
        if(isset($this->_data[$key])){
            return $this->_data[$key];
        }
        else{
            return null;
        }
    }
    
    /**
     * 获取所有字典所有数据数组
     * @return array 
     */
    public function getData(){
        return $this->_data;
    }
    
    /**
     * 设置数据键对应值 
     */
    public function setValue($key, $value){
        $this->_data[$key] = $value;
    }
    
    
}