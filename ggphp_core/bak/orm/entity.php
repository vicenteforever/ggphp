<?php

/**
 * 实体对象类，对应数据库中的一条记录
 * @package orm
 * @author goodzsq@gmail.com
 */
class orm_entity {

    /** @var boolean */
    protected $_loaded = false;

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
     * 实体所属的模型
     * @return orm_model 
     */
    public function model() {
        return $this->_model;
    }

    /**
     * 保存对象
     * @return boolean 
     */
    public function save() {
        $primary = $this->_model->primaryKey();
        $primaryValue = $this->$primary;
        $table = $this->_model->getTableName();
        $data = array();
        foreach($this->_model->fieldset()->fields() as $name => $field){
            $value = $field->save($this->$name);
            $data[$name] = $value;
        }
        if ($this->loaded()) {
            return $this->_model->adapter()->update($table, $data, array($primary => $primaryValue));
        } else {
            return $this->_model->adapter()->create($table, $data);
        }
    }

    /**
     * 删除对象
     * @return boolean 
     */
    public function delete() {
        $primary = $this->_model->primaryKey();
        $primaryValue = $this->$primary;
        $table = $this->_model->getTableName();
        return $this->_adapter->delete($table, array($primary => $primaryValue));
    }

    /**
     * 校验数据
     * @param orm_entity $entity
     * @return array 
     */
    public function validate() {
        $fieldset = $this->_model->fieldset();
        $error = array();
        foreach ($fieldset->fields() as $key => $field) {
            $err = $field->validate($this);
            if ($err !== true) {
                $error[$key] = $err;
            }
        }
        return $error;
    }

    /**
     * 屏蔽错误
     * @param type $name 
     */
    public function __get($name) {
        return null;
    }

}
