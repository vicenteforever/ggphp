<?php

/**
 * 实体对象类，对应数据库中的一条记录
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
     * 实体所属的模型
     * @return orm_model 
     */
    public function model() {
        return $this->_model;
    }

    /**
     * 取出字段数据
     * @param string $fieldName
     * @return null 
     */
    public function data($fieldName){
        if(isset($this->_data[$fieldName])){
            return $this->_data[$fieldName];
        }
        else{
            return null;
        }
    }
    
    /**
     * 保存对象
     * @return boolean 
     */
    public function save() {
        $primary = $this->_model->primaryKey();
        $primaryValue = $this->data($primary);
        $table = $this->_model->getTableName();
        if($this->loaded()){
            $this->_model->adapter()->update($table, $this->_data, array($primary => $primaryValue));
        } else {
            $this->_model->adapter()->create($table, $data);
        }
        
    }

    /**
     * 删除对象
     * @return boolean 
     */
    public function delete() {
        $primary = $this->_model->primaryKey();
        $primaryValue = $this->data($primary);
        $table = $this->_model->getTableName();
        return $this->_adapter->delete($table, array($primary => $primaryValue));
    }

    /**
     * 校验数据
     * @param orm_entity $entity
     * @return mixed 
     */
    public function validate() {
        return $this->_fieldset->validate($entity);
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
        if (!$this->_model->fieldExists($name)) {
            app()->log('字段取值失败:orm_entity->' . $name, null, core_app::LOG_WARN);
            return null;
        }
        $field = $this->_model->field($name);
        return $field->getObject($this->_data[$name]);
    }

    public function __set($name, $value) {
        if (!$this->_model->fieldExists($name)) {
            app()->log('字段赋值失败:orm_entity->' . $name, $value, core_app::LOG_WARN);
            return;
        }
        $field = $this->_model->field($name);
        $key = $field->setValue($value);
        $this->_data[$name] = $key;
    }

}
