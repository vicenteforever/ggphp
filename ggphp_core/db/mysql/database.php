<?php

/**
 * 数据库对象资源
 * 用于创建删除修改数据库表
 * @package 
 * @author $goodzsq@gmail.com
 */
class db_mysql_database implements rest_interface {

    private $_dsn;
    private $_dbh;
    private $_database;
    private $_engine = 'InnoDB';
    private $_charset = 'utf8';
    private $_collate = 'utf8_general_ci';
    private $_fieldTypeMap = array(
        'string' => 'varchar',
        'text' => 'text',
        'int' => 'int',
        'integer' => 'int',
        'bool' => 'tinyint',
        'boolean' => 'tinyint',
        'decimal' => 'decimal',
        'float' => 'float',
        'double' => 'double',
        'date' => 'date',
        'datetime' => 'datetime',
        'time' => 'time',
    );

    public function __construct($dsn) {
        $this->_dsn = $dsn;
        $config = config('database', $dsn);
        $this->_dbh = mysql_connect($config['host'], $config['username'], $config['password']);
        $this->_database = $config['database'];
        mysql_select_db($this->_database, $this->_dbh);
        if (!empty($config['charset'])) {
            db_mysql_helper::exec("SET NAMES {$config['charset']}", $this->_dbh);
        }
    }

    /**
     * 删除表
     * @param string $id 表名称
     * @return boolean
     */
    public function delete($id) {
        $sql = "DROP TABLE `$id`";
        return db_mysql_helper::exec($sql, $this->_dbh);
    }

    /**
     * 删除所有表 
     */
    public function deleteAll() {
        $tables = $this->index();
        foreach ($tables as $key => $value) {
            $this->delete($key);
        }
    }

    /**
     * 获取表
     * @param string $id 
     * @return rest_interface
     */
    public function get($id) {
        static $object = null;
        $identity = $this->_dsn . '_' . $id;
        if (!isset($object[$identity])) {
            $object[$identity] = new db_mysql_table($this->_dbh, $id);
        }
        return $object[$identity];
    }

    /**
     * 列出数据库表
     * @param type $params
     * @return type 
     */
    public function index($params = null) {
        if (isset($params['database'])) {
            $clause = " FROM {$params['database']}";
        } else {
            $clause = "";
        }
        return db_mysql_helper::queryArray("SHOW TABLES $clause", $this->_dbh, 'Tables_in_' . $this->_database);
    }

    /**
     * 创建表
     * @param string $id 表名称
     * @param array $data 字段集数组field_type_base[]
     * @return boolean
     */
    public function post($id, $data) {
        return $this->createTable($id, $data);
    }

    /**
     * 修改表，如果表不存在的话创建表
     * @param string $id 表名称
     * @param array $data 字段集数组field_type_base[]
     * @return boolean 
     */
    public function put($id, $data) {
        $tableList = $this->index();
        if (!isset($tableList[$id])) {
            return $this->createTable($id, $data);
        } else {
            return $this->modifyTable($id, $data);
        }
    }

    public function struct() {
        
    }

    /**
     * 创建列语法
     * @param field_type_base $field
     * @return string
     * @throws phpDataMapper_Exception 
     */
    private function syntaxField(field_type_base $field) {
        if (!isset($this->_fieldTypeMap[$field->type])) {
            throw new exception("Field type {$field->type} not supported");
        }
        $fieldMapType = $this->_fieldTypeMap[$field->type];
        $syntax = "`{$field->name}` " . $fieldMapType;
        if ($field->length) {
            $syntax .= "({$field->length})";
        }
        if ($field->unsigned == true) {
            $syntax .= ' unsigned';
        }
        if ($field->type == 'string' || $field->type == 'text') {
            $syntax .= " COLLATE {$this->_collate}";
        }
        if ($field->required || !$field->allowNull) {
            $syntax .= " NOT NULL";
            $allowNull = false;
        } else {
            $allowNull = true;
        }
        if ($field->default === null && $allowNull) {
            $syntax .= " DEFAULT NULL";
        } elseif ($field->default !== null) {
            $syntax .= " DEFAULT '{$field->default}'";
        }
        if ($field->index == 'primary' && $field->serial) {
            $syntax .= " AUTO_INCREMENT";
        }
        return $syntax;
    }

    private function createTable($table, array $fields) {
        $columnsSyntax = array();
        $primary = '';
        $unique = '';
        $index = '';
        foreach ($fields as $key => $field) {
            /* @var $field field_type_base */
            $columnsSyntax[] = $this->syntaxField($field);
            if ($field->index == 'primary') {
                $primary .= "\n, PRIMARY KEY(`$field->name`)";
            } elseif ($field->index == 'unique') {
                $unique .= "\n, UNIQUE KEY `$field->name` (`$field->name`)";
            } elseif ($field->index == 'index') {
                $index .= "\n, KEY `$field->name` (`$field->name`)";
            }
        }

        $syntax = "CREATE TABLE IF NOT EXISTS `{$table}` (\n";
        $syntax .= implode(",\n", $columnsSyntax);
        $syntax .= $primary . $unique . $index;
        $syntax .= "\n) ENGINE={$this->_engine} DEFAULT CHARSET={$this->_charset} COLLATE={$this->_collate};";
        return db_mysql_helper::exec($syntax, $this->_dbh);
    }

    private function modifyTable($table, array $fields) {
        $result = true;
        //修改列属性
        $existsColumns = $this->getColumnsFromTable($table);
        $existsIndexs = $this->getIndexFromTable($table);
        $columnsSyntax = array();
        $primary = '';
        $unique = '';
        $index = '';

        try {
            foreach ($fields as $key => $field) {
                /* @var $field field_type_base */
                if (isset($existsColumns[$key])) {
                    $columnsSyntax[] = 'MODIFY ' . $this->syntaxField($field);
                } else {
                    $columnsSyntax[] = 'ADD COLUMN ' . $this->syntaxField($field);
                }
            }
        } catch (Exception $exc) {
            app()->log($exc->getMessage(), core_app::LOG_ERROR);
        }



        $syntax = "ALTER TABLE `$table` \n";
        $syntax .= implode(",\n", $columnsSyntax);
        $result = $result && db_mysql_helper::exec($syntax, $this->_dbh);

        //修改索引
        foreach ($fields as $key => $field) {
            //primary
            if ($field->index == 'primary') {
                $result = $result && db_mysql_helper::exec("ALTER TABLE `$table` DROP PRIMARY KEY, ADD PRIMARY KEY(`{$field->name}`);", $this->_dbh);
            }
            //unique
            if ($field->index == 'unique') {
                if (isset($existsIndexs[$key])) {
                    $result = $result && db_mysql_helper::exec("ALTER TABLE `$table` DROP INDEX `$key` , ADD UNIQUE  `$key` (  `$key` )", $this->_dbh);
                } else {
                    $result = $result && db_mysql_helper::exec("ALTER TABLE `$table` ADD UNIQUE  `$key` (  `$key` )", $this->_dbh);
                }
            }
            //index
            if ($field->index == 'index') {
                if (isset($existsIndexs[$key])) {
                    $result = $result && db_mysql_helper::exec("ALTER TABLE `$table` DROP INDEX `$key` , ADD INDEX  `$key` (  `$key` )", $this->_dbh);
                } else {
                    $result = $result && db_mysql_helper::exec("ALTER TABLE `$table` ADD INDEX  `$key` (  `$key` )", $this->_dbh);
                }
            }
            //drop index
            if (isset($existsIndexs[$key]) && empty($field->index)) {
                $result = $result && db_mysql_helper::exec("ALTER TABLE `$table` DROP INDEX `$key`", $this->_dbh);
            }
        }

        //删除多余的列
        foreach ($existsColumns as $key => $value) {
            if (!isset($fields[$key])) {
                $result = $result && db_mysql_helper::exec("ALTER TABLE `$table` DROP `$key`", $this->_dbh);
            }
        }
        return $result;
    }

    /**
     * 从数据库表获取列信息
     * @param string $table 表名称
     * @return array 
     */
    private function getColumnsFromTable($table) {
        $sql = "SELECT * FROM information_schema.columns WHERE table_schema = '{$this->_database}' AND table_name = '{$table}'";
        return db_mysql_helper::queryArray($sql, $this->_dbh, 'COLUMN_NAME');
    }

    /**
     * 列出表的所有索引
     * @param string $table
     * @return array 
     */
    private function getIndexFromTable($table) {
        $sql = "SHOW INDEX FROM $table";
        return db_mysql_helper::query($sql, $this->_dbh, 'Key_name');
    }

}