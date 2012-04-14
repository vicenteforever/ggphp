<?php

/**
 * orm_model
 * @package
 * @author goodzsq@gmail.com
 */
class orm_model {

    /** @var orm_adapter_pdo 数据库适配器 */
    protected $_adapter;

    /** @var orm_fieldset 字段集对象 */
    protected $_fieldset;

    /** @var string 表名称 */
    protected $_tableName;

    /** @var string entity实体类名称 */
    protected $_entityClassName = 'orm_entity';

    public function __construct($tableName) {
        $configData = config('app', 'orm');
        $adapter = $configData['adapter'];
        $database = $configData['database'];
        $this->_adapter = new $adapter($database);
        $this->_tableName = $tableName;
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
    public function fieldset() {
        return $this->_fieldset;
    }
    
    public function primaryKey(){
        return $this->_fieldset->primaryKey();
    }
    
    /**
     *获取字段
     * @param string $fieldName
     * @return field_type_base 
     */
    public function field($fieldName){
        return $this->_fieldset->field($fieldName);
    }
    
    /**
     *检查字段是否存在
     * @param string $fieldName
     * @return boolean 
     */
    public function fieldExists($fieldName){
        return $this->_fieldset->fieldExists($fieldName);
    }

    /**
     * 表名称
     * @return string 
     */
    public function getTableName() {
        return $this->_tableName;
    }

    /**
     * 实体类名称
     * @return string 
     */
    public function getEntityClassName() {
        return $this->_entityClassName;
    }

    /**
     * 查询
     * @param mixed $where
     * @return orm_recordset 
     */
    public function query($whereCondition='', $limit = null, $offset = 0) {
        $whereClause = "";
        if (is_string($whereCondition)) {
            $whereClause = $whereCondition;
            $params = null;
        } else if (is_array($whereCondition)) {
            $where = array();
            $params = array();
            foreach ($whereCondition as $key => $value) {
                $where[] = "$key = :$key";
                $params[":$key"] = $value;
            }
            $whereClause = implode(' AND ', $where);
        }

        if (!empty($whereClause)) {
            $whereClause = " WHERE $whereClause ";
        }

        $sql = "SELECT * FROM {$this->_tableName} $whereClause";
        if (isset($limit)) {
            $stmt = $this->adapter()->queryLimit($sql, $params, $limit, $offset);
        } else {
            $stmt = $this->adapter()->query($sql);
        }
        if ($stmt instanceof PDOStatement) {
            return new orm_recordset($this, $stmt);
        } else {
            return null;
        }
    }

    /**
     * 获取实体对象
     * @param mixed $primaryKeyValue
     * @return \orm_entity 
     */
    public function load($primaryKeyValue = null) {
        if (isset($primaryKeyValue)) {
            $primaryKey = $this->_fieldset->primaryKey();
            $recordset = $this->query(array($primaryKey => $primaryKeyValue), 1);
            if ($recordset) {
                $result = $recordset->fetchEntity();
            }
        }
        if (!isset($result)) {
            $result = new orm_entity($this);
        }
        return $result;
    }

    /**
     * 重建数据库 
     */
    public function migrate(){
        return $this->_adapter->migrate($this->_fieldset);
    }

}

