<?php

include_once(GG_DIR . '/lib/phpDataMapper/Base.php');

class orm_mapper extends phpDataMapper_Base {

    protected $_fieldset;
    
    /**
     * orm构造器
     * @param string $tableName config/table下配置文件名称
     */
    public function __construct($tableName) {
        $fieldset = new orm_fieldset($tableName);
        foreach ($fieldset->fields() as $fieldName => $field) {
            $this->_datasource = $fieldset->table();
            $arr = array();
            $arr['type'] = $field->type;
            $arr['default'] = $field->default;
            $arr['length'] = $field->length;
            $arr['required'] = $field->required;
            $arr['null'] = $field->null;
            $arr['unsigned'] = $field->unsigned;
            $arr['primary'] = $field->primary;
            $arr['index'] = $field->index;
            $arr['unique'] = $field->unique;
            $arr['serial'] = $field->serial;
            $arr['relation'] = $field->relation;
            $this->$fieldName = $arr;
        }
        $this->_fieldset = $fieldset;
        parent::__construct(self::getAdapterFromConfig());
    }

    /**
     * 获取phpDataMapper数据库适配器
     * @staticvar phpDataMapper_Adapter_Mysql $adapter
     * @param type $config
     * @return \phpDataMapper_Adapter_Mysql 
     */
    static public function getAdapterFromConfig($config = 'default') {
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
                            $dbconfig['options']
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
        return self::getAdapterFromConfig($config)->connection();
    }
    
    /**
     * 获取字段集
     * @return orm_fieldset
     */
    public function fieldset() {
        return $this->_fieldset;
    }

    /**
     * 校验数据
     * @param phpDataMapper_Entity $entity
     * @return boolean 
     */
    public function validate(phpDataMapper_Entity $entity) {
        $error = $this->_fieldset->validate($entity);
        if (empty($error)) {
            return true;
        } else {
            foreach ($error as $field => $msg) {
                $this->error($field, $msg);
            }
            return false;
        }
    }

    /**
     * 输出查询语句
     */
    public function debug() {
        $buf = "Executed " . $this->queryCount() . " queries:</p>";
        $buf .= trace(self::$_queryLog);
        app()->log($buf);
        return $buf;
    }

    public function execute($sql, $binds) {
        self::logQuery($sql, $binds);
        if ($stmt = $this->adapter()->prepare($sql)) {
            $results = $stmt->execute($binds);
        } else {
            throw new $this->_exceptionClass(__METHOD__ . " Error: Unable to execute SQL query - failed to create prepared statement from given SQL");
        }
    }

}