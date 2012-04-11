<?php

/**
 * orm_model
 * @package
 * @author goodzsq@gmail.com
 */
class orm_model {

    /** @var orm_adapter_pdo 数据库适配器 */
    private $_adapter;

    /** @var orm_fieldset 字段集对象 */
    private $_fieldset;

    /** @var string 表名称 */
    private $_table;

    public function __construct($tableName) {
        $configData = config('app', 'orm');
        $adapter = $configData['adapter'];
        $database = $configData['database'];
        $this->_adapter = new $adapter($database);
        $this->_table = $tableName;
        $this->_fieldset = new orm_fieldset($tableName);
    }

    /**
     * 数据库适配器对象
     * @return orm_adapter_pdo
     */
    public function adapter() {
        return $this->_adapter;
    }
    
    /**
     * 字段集对象
     * @return orm_fieldset
     */
    public function fieldset(){
        return $this->_fieldset;
    }

    public function query($where){
        $sql = "SELECT * FROM {$this->_table} WHERE $where";
        return $this->adapter()->query($sql);
    }
    
    /**
     * 获取实体对象
     * @param mixed $primaryKeyValue
     * @return \orm_entity 
     */
    public function load($primaryKeyValue = null, $entity_class='orm_entity') {
        if (isset($primaryKeyValue)) {
            $key = $this->_fieldset->primaryKey();
            $sql = "SELECT * FROM {$this->_table} WHERE $key=:$key";
            $stmt = $this->_adapter->queryLimit($sql, array(":$key"=>$primaryKeyValue), 1, 0);
            $stmt->setFetchMode(PDO::FETCH_CLASS, $entity_class);
            if ($row = $stmt->fetch(PDO::FETCH_CLASS)) {
                $row->loaded(true);
                return $row;
            }
        }
        return new orm_entity();
    }

    /**
     * 保存对象
     * @param orm_entity $entity
     * @return boolean 
     */
    public function save(orm_entity $entity) {
        $primary = $this->_fieldset->primaryKey();
        $primaryValue = $entity->$primary;
        if ($entity->loaded()) {
            return $this->_adapter->update($this->_table, $entity->getData(), array($primary => $primaryValue));
        } else {
            return $this->_adapter->create($this->_table, $entity->getData());
        }
    }
    
    /**
     * 删除对象
     * @param orm_entity $entity
     * @return boolean 
     */
    public function delete(orm_entity $entity){
        $primary = $this->_fieldset->primaryKey();
        $primaryValue = $entity->$primary;
        return $this->_adapter->delete($this->_table, array($primary => $primaryValue));
    }
    
    public function validate(orm_entity $entity){
        $error = $this->_fieldset->validate($entity);
        if (empty($error)) {
            return true;
        } else {
            return false;
        }        
    }

}

