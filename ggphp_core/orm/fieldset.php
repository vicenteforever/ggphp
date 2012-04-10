<?php

class orm_fieldset {

    protected $_fields;
    protected $_table;

    /**
     * orm_helper构造器
     * @param string $tableName 数据配置表名称
     * @throws Exception 
     */
    public function __construct($tableName) {
        $this->_table = $tableName;
        if (!is_array($this->_fields))
            $this->_fields = array();
        $config = config("table/{$tableName}");
        if (!is_array($config))
            $config = array();
        $config = array_merge($this->_fields, $config);
        foreach ($config as $v) {
            if (empty($v['name'])) {
                throw new Exception('field name not assign');
            }
            $fieldType = "field_type_{$v['field']}";
            $fieldObject = new $fieldType($v);
            $this->_fields[$v['name']] = $fieldObject;
        }
    }

    /**
     * 增加字段
     * @param array $fieldInfo 
     */
    public function addField($fieldInfo) {
        $fieldName = "field_type_{$fieldInfo['field']}";
        $this->_fields[$fieldInfo['name']] = new $fieldName($fieldInfo);
    }

    /**
     * 根据字段名称获取字段对象
     * @param string $fieldName
     * @return mixed 
     */
    public function field($fieldName) {
        if (isset($this->_fields[$fieldName])) {
            return $this->_fields[$fieldName];
        } else {
            return null;
        }
    }

    /**
     * 获取所有字段对象数组
     * @return array 
     */
    public function fields() {
        return $this->_fields;
    }

    /**
     * 获取字段值
     * @param string $field
     * @param phpDataMapper_Entity $entity
     * @return mixed 
     */
    public function fieldValue($field, phpDataMapper_Entity $entity) {
        if (!isset($this->_fields[$field])) {
            return null;
        }
        if (isset($entity->$field)) {
            return $entity->$field;
        } else {
            return null;
        }
    }

    /**
     * 校验检查值
     * @return array
     */
    public function validate() {
        $error = array();
        foreach ($this->_fields as $k => $field) {
            $err = $field->validate();
            if ($err !== true) {
                $error[$k] = $err;
            }
        }
        return $error;
    }

    /**
     * 获取数据配置表名称(表名称)
     * @return string 
     */
    public function table() {
        return $this->_table;
    }

    /**
     * 屏蔽未定义属性警告
     * @param type $name 
     */
    public function __get($name) {
        ;
    }

}