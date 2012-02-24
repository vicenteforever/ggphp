<?php

class orm_helper {

    protected $_fields;
    protected $_schema;

    function __construct($schemaName) {
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
            $fieldType = "field_{$v['field']}_type";
            $fieldObject = new $fieldType($v);
            $this->_fields[$v['name']] = $fieldObject;
        }
    }

    function field($fieldName = null) {
        if (isset($fieldName)) {
            if (isset($this->_fields[$fieldName])) {
                $this->_fields[$fieldName];
            } else {
                return null;
            }
        } else {
            return $this->_fields;
        }
    }

    function fieldValue($field, $entity) {
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
     * @param type $entity 
     * @return array
     */
    function validate($entity) {
        $error = array();
        foreach ($this->_fields as $k => $v) {
            $value = $this->fieldValue($k, $entity);
            $err = $v->validate($value);
            if ($err !== true) {
                $error[$k] = $err;
            }
        }
        return $error;
    }

    /**
     * 构建输入窗体
     * @param string $action
     * @param entity $default
     * @param string $prefix
     * @param string $suffix
     * @return string 
     */
    function form($action, $default = null, $prefix = '', $suffix = '') {
        $buf = "<form method=\"POST\" name=\"{$this->_schema}\" action=\"$action\">{$prefix}";
        foreach ($this->_fields as $k => $v) {
            $value = $this->fieldValue($k, $default);
            if ($v->hidden) {//@todo: 
                $buf .= $v->widget_hidden($value) . '<br />';
            } else {
                $buf .= $v->widget_input($value) . '<br />';
            }
        }
        $buf .= "<input type=submit />";
        $buf .= "{$suffix}</form>";
        return $buf;
    }

    function schema() {
        return $this->_schema;
    }

    function adapter() {
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
       
}