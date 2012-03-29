<?php

include_once(GG_DIR . '/lib/phpDataMapper/Base.php');

class orm_mapper extends phpDataMapper_Base {

    protected $_helper;

    /**
     * orm构造器
     * @param string $schemaName config/schema配置文件名 
     */
    public function __construct($schemaName) {
        $helper = new orm_helper($schemaName);
        foreach ($helper->fields() as $fieldName => $field) {
            $this->_datasource = $helper->schema();
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
        $this->_helper = $helper;
        parent::__construct(orm_helper::adapter());
    }

    /**
     * 获取orm_helper
     * @return orm_helper
     */
    public function helper() {
        return $this->_helper;
    }

    /**
     * 校验数据
     * @param phpDataMapper_Entity $entity
     * @return boolean 
     */
    public function validate(phpDataMapper_Entity $entity) {
        $error = $this->_helper->validate($entity);
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