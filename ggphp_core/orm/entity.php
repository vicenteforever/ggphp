<?php

/**
 * 实体对象，对应一条记录
 * @package orm
 * @author goodzsq@gmail.com
 */
class orm_entity {

    /** @var boolean */
    protected $_loaded = false;

    /** @var array */
    protected $_data = array();

    /** @var orm_model */
    protected $_model;

    /**
     * constructor
     * @param orm_fieldset $fieldset 
     */
    public function __construct(orm_model $model) {
        $this->_model = $model;
    }

    /**
     * 设置或者读取实体数据是否是从数据库中加载的，根据此变量来决定是insert还是update到数据库
     * @param boolean $val
     * @return boolean 
     */
    public function loaded($val = null) {
        if (isset($val)) {
            $this->_loaded = (boolean) $val;
        } else {
            return $this->_loaded;
        }
    }

    /**
     * 数据校验 
     */
    public function validate() {
        
    }

    /**
     * 实体所属的模型
     * @return orm_model 
     */
    public function model() {
        return $this->_model;
    }

    /**
     * 保存到持久对象 
     * @return boolean
     */
    public function save() {
        return $this->_model->save($this);
    }

    /**
     * 从持久对象中删除 
     * @return boolean
     */
    public function delete() {
        return $this->_model->delete($this);
    }

    /**
     * 转换成数组
     * @return array 
     */
    public function toArray() {
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

