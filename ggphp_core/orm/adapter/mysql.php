<?php

/**
 * orm_adapter_mysql
 * @package
 * @author goodzsq@gmail.com
 */
class orm_adapter_mysql extends orm_adapter_pdo {

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

    /**
     * 创建数据库
     * @param string $source 数据库名称
     * @return bool 
     */
    public function createDatabase($source) {
        $sql = "CREATE DATABASE `$source` DEFAULT CHARACTER SET {$this->_charset} COLLATE {$this->_collate}";
        return $this->execute($sql);
    }

    /**
     * 检查表是否存在
     * @param string $table 表名称
     * @return boolean 
     */
    public function tableExists($table) {
        $sql = "SHOW TABLES LIKE :source";
        $stmt = $this->query($sql, array(':source' => $table));
        if ($stmt) {
            return $stmt->rowCount() == 1 ? true : false;
        } else {
            return false;
        }
    }

    /**
     * 创建表
     * @param orm_fieldset $fieldset 字段集对象
     * @return boolean 
     */
    public function createTable(orm_fieldset $fieldset) {
        $columnsSyntax = array();
        $primary = '';
        $unique = '';
        $index = '';
        foreach ($fieldset->fields() as $key => $field) {
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

        $syntax = "CREATE TABLE IF NOT EXISTS `" . $fieldset->table() . "` (\n";
        $syntax .= implode(",\n", $columnsSyntax);
        $syntax .= $primary . $unique . $index;
        $syntax .= "\n) ENGINE={$this->_engine} DEFAULT CHARSET={$this->_charset} COLLATE={$this->_collate};";
        return $this->execute($syntax);
    }

    /**
     * 更新表
     * @param orm_fieldset $fieldset 字段集对象
     */
    public function updateTable(orm_fieldset $fieldset) {
        //修改列属性
        $existsColumns = $this->getColumnsFromTable($fieldset->table());
        $existsIndexs = $this->getIndexFromTable($fieldset->table());
        $columnsSyntax = array();
        $primary = '';
        $unique = '';
        $index = '';
        foreach ($fieldset->fields() as $key => $field) {
            /* @var $field field_type_base */
            if (isset($existsColumns[$key])) {
                $columnsSyntax[] = 'MODIFY ' . $this->syntaxField($field);
            } else {
                $columnsSyntax[] = 'ADD COLUMN ' . $this->syntaxField($field);
            }
        }
        $table = $fieldset->table();
        $syntax = "ALTER TABLE `$table` \n";
        $syntax .= implode(",\n", $columnsSyntax);
        $this->execute($syntax);

        //修改索引
        foreach ($fieldset->fields() as $key => $field) {
            //primary
            if ($field->index == 'primary') {
                $this->execute("ALTER TABLE `$table` DROP PRIMARY KEY, ADD PRIMARY KEY(`{$field->name}`);");
            }
            //unique
            if ($field->index == 'unique') {
                if (isset($existsIndexs[$key])) {
                    $this->execute("ALTER TABLE `$table` DROP INDEX `$key` , ADD UNIQUE  `$key` (  `$key` )");
                } else {
                    $this->execute("ALTER TABLE `$table` ADD UNIQUE  `$key` (  `$key` )");
                }
            }
            //index
            if ($field->index == 'index') {
                if (isset($existsIndexs[$key])) {
                    $this->execute("ALTER TABLE `$table` DROP INDEX `$key` , ADD INDEX  `$key` (  `$key` )");
                } else {
                    $this->execute("ALTER TABLE `$table` ADD INDEX  `$key` (  `$key` )");
                }
            }
            //drop index
            if (isset($existsIndexs[$key]) && empty($field->index)) {
                $this->execute("ALTER TABLE `$table` DROP INDEX `$key`");
            }
        }
        
        //删除多余的列
        
        foreach($existsColumns as $key=>$value){
            if($fieldset->field($key) == null){
                $this->execute("ALTER TABLE `$table` DROP `$key`");
            }
        }
    }

    /**
     * 创建列语法
     * @param field_type_base $field
     * @return string
     * @throws phpDataMapper_Exception 
     */
    public function syntaxField(field_type_base $field) {
        if (!isset($this->_fieldTypeMap[$field->type])) {
            throw new exception("Field type {$field->type} not supported");
        }
        $field->type = $this->_fieldTypeMap[$field->type];
        $syntax = "`{$field->name}` " . $field->type;
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

    /**
     * 从数据库表获取列信息
     * @param string $table 表名称
     * @return array 
     */
    public function getColumnsFromTable($table) {
        $sql = "SELECT * FROM information_schema.columns WHERE table_schema = '{$this->_database}' AND table_name = '{$table}'";
        $stmt = $this->query($sql);
        $result = array();
        while ($row = $stmt->fetch()) {
            $result[$row['COLUMN_NAME']] = $row;
        }
        return $result;
    }

    /**
     * 列出表的所有索引
     * @param string $table
     * @return array 
     */
    public function getIndexFromTable($table) {
        $sql = "SHOW INDEX FROM $table";
        $stmt = $this->query($sql);
        $result = array();
        while ($row = $stmt->fetch()) {
            $result[$row['Key_name']] = $row;
        }
        return $result;
    }

    /**
     * 执行分页查询
     * @param string $sql
     * @param int $nrow
     * @param int $offset 
     * @return PDOStatement
     */
    public function queryLimit($sql, $params, $limit, $offset) {
        $sql .= " LIMIT $offset, $limit";
        return $this->query($sql, $params);
    }

}

