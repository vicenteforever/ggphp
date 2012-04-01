<?php

class orm_helper {

    protected $_fields;
    protected $_schema;

    /**
     * orm_helper构造器
     * @param string $schemaName 数据配置表名称
     * @throws Exception 
     */
    public function __construct($schemaName) {
        $this->_schema = $schemaName;
        if (!is_array($this->_fields))
            $this->_fields = array();
        $config = config("schema/{$schemaName}");
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
        $fieldName = "field_{$fieldInfo['field']}";
        $this->_fields[$fieldInfo['name']] = new $fieldName($fieldInfo);
    }

    /**
     * 根据字段名称获取字段对象
     * @param string $fieldName
     * @return mixed 
     */
    public function field($fieldName) {
        if (isset($this->_fields[$fieldName])) {
            $this->_fields[$fieldName];
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
    public function schema() {
        return $this->_schema;
    }

    /**
     * 获取phpDataMapper数据库适配器
     * @staticvar phpDataMapper_Adapter_Mysql $adapter
     * @param type $config
     * @return \phpDataMapper_Adapter_Mysql 
     */
    static public function adapter($config = 'default') {
        static $adapter;
        if (!isset($adapter)) {
            include(GG_DIR . '/lib/phpDataMapper/Adapter/PDO.php');
            include(GG_DIR . '/lib/phpDataMapper/Adapter/Mysql.php');
            $dbconfig = config('database', 'default');
            $adapter = new phpDataMapper_Adapter_Mysql(
                            $dbconfig['host'],
                            $dbconfig['database'],
                            $dbconfig['username'],
                            $dbconfig['password'],
                            $dbconfig['driver_opts']
            );
        }
        return $adapter;
    }

    /**
     * 获取pdo链接
     * @param string $config
     * @return PDO 
     */
    static public function pdo($config = null) {
        return self::adapter($config)->connection();
    }

    public function __get($name) {
        ;
    }

}