<?php

/**
 * 实体对象，对应一条记录
 * @package orm
 * @author goodzsq@gmail.com
 */
class orm_entity {

    protected $_loaded = false;
    protected $_data = array();
    
    /**
     * 设置或者读取实体数据是否从数据库中加载
     * @param boolean $val
     * @return boolean 
     */
    public function loaded($val=null){
        if(isset($val)){
            $this->_loaded = (boolean)$val;
        }
        else{
            return $this->_loaded;
        }
    }
    
    public function getData() {
        return $this->_data;
    }

    public function __isset($key) {
        return ($this->$key !== null) ? true : false;
    }

    public function __get($name) {
        $method_name = 'get_' . $name;
        if (method_exists($this, $method_name)) {
            return $this->$method_name();
        } else {
            if (isset($this->_data[$name])) {
                return $this->_data[$name];
            } else {
                return null;
            }
        }
    }

    public function __set($name, $value) {
        $method_name = 'set_' . $name;
        if (method_exists($this, $method_name)) {
            $this->$method_name($value);
        } else {
            $this->_data[$name] = $value;
        }
    }

}

