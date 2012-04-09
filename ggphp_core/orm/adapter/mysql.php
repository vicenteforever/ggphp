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

    public function createDatabase($source) {
        $sql = "CREATE DATABASE `$source` DEFAULT CHARACTER SET {$this->_charset} COLLATE {$this->_collate}";
        return $this->execute($sql);
    }

    public function tableExists($source) {
        $sql = "SHOW TABLES LIKE :source";
        $stmt = $this->query($sql, array(':source' => $source));
        if ($stmt) {
            return $stmt->rowCount() == 1 ? true : false;
        } else {
            return false;
        }
    }

    public function createTable(orm_fieldset $fieldset) {
        $columnsSyntax = array();
        $primary = '';
        $unique = '';
        $index = '';
        foreach ($fieldset->fields() as $key => $field) {
            /* @var $field field_type_base */
            $columnsSyntax = $this->syntaxField($field);
            if ($field->primary) {
                $primary .= "\n, PRIMARY KEY(`$field->name`)";
            }
            if ($field->unique) {
                $unique .= "\n, UNIQUE KEY `$field->name` (`$field->name`)";
            }
            if ($field->index) {
                $index .= "\n, KEY `$field->name` (`$field->name`)";
            }
        }

        $syntax = "CREATE TABLE IF NOT EXISTS `" . $fieldset->table() . "` (\n";
        $syntax .= implode(",\n", $columnsSyntax);
        $syntax .= $primary . $unique . $index;
        $syntax .= "\n) ENGINE={$this->_engine} DEFAULT CHARSET={$this->_charset} COLLATE={$this->_collate};";
        return $this->execute($syntax);
    }

    public function updateTable(orm_fieldset $fieldset) {
        //@todo goodzsq updatetable syntax
        $existsColumns = $this->getColumnsForTable($fieldset->table());
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

            if ($field->primary) {
                $primary .= "\n, PRIMARY KEY(`$field->name`)";
            }
            if ($field->unique) {
                $unique .= "\n, UNIQUE KEY `$field->name` (`$field->name`)";
            }
            if ($field->index) {
                $index .= "\n, KEY `$field->name` (`$field->name`)";
            }
        }

        $syntax = "ALTER TABLE `" . $fieldset->table() . "` \n";
        $syntax .= implode(",\n", $columnsSyntax);
        $syntax .= $primary . $unique . $index;
        return $this->execute($syntax);
    }

    /**
     * 创建列的语法
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
        if ($field->primary && $field->serial) {
            $syntax .= " AUTO_INCREMENT";
        }
        return $syntax;
    }

    /**
     * 从数据库表获取列信息
     * @param string $table 表名称
     * @return array 
     */
    public function getColumnsForTable($table) {
        $sql = "SELECT * FROM information_schema.columns WHERE table_schema = '{$this->_database}' AND table_name = '{$table}'";
        $stmt = $this->query($sql);
        $result = array();
        while ($row = $stmt->fetch()) {
            $result[$row['COLUMN_NAME']] = $row;
        }
        return $result;
    }

}

