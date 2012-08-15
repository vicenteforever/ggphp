<?php

/**
 * 字段集对象 用于数据库创建 窗体构建等
 * @package field
 * @author goodzsq@gmail.com
 */
class field_collection {

    /** @var array 字段集关联数组 */
    protected $_fields = array();

    /** @var string 主键名称 */
    protected $_primaryKey;

    /**
     * 创建字段集对象
     * @param array $arr 字段描述数组
     * @throws Exception 
     */
    public function __construct(array $arr) {
        foreach ($arr as $row) {
            $this->addField($row);
        }
    }

    /**
     * 增加字段
     * @param array $arr
     */
    public function addField(array $arr) {
        if (empty($arr['name'])) {
            throw new Exception('field name not assign');
        }
        if (empty($arr['name'])) {
            throw new Exception('field type not assign');
        }
        $fieldType = "field_type_" . $arr['field'];
        $fieldObject = new $fieldType($arr);
        if ($fieldObject instanceof field_type_base) {
            $this->_fields[$arr['name']] = $fieldObject;
            if ($fieldObject->index == 'primary') {
                $this->_primaryKey = $fieldObject->name;
            }
        } else {
            throw new Exception("$fieldType not exist");
        }
    }

    /**
     * 移除字段
     * @param string $fieldName 
     */
    public function removeField($fieldName) {
        unset($this->_fields[$fieldName]);
    }

    /**
     * 根据字段名称获取字段对象
     * @param string $fieldName
     * @return field_type_base 
     */
    public function field($fieldName) {
        if (isset($this->_fields[$fieldName])) {
            return $this->_fields[$fieldName];
        } else {
            return null;
        }
    }

    /**
     * 判断字段是否存在
     * @param string $fieldName
     * @return boolean
     */
    public function fieldExists($fieldName) {
        if (isset($this->_fields[$fieldName])) {
            return true;
        } else {
            return false;
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
     * 获取主键名称
     * @return string 
     */
    public function primaryKey() {
        return $this->_primaryKey;
    }

}