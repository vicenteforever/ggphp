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

        $syntax = "CREATE TABLE IF NOT EXISTS `" . $fieldset->schema() . "` (\n";
        $syntax .= implode(",\n", $columnsSyntax);
        $syntax .= $primary . $unique . $index;
        $syntax .= "\n) ENGINE={$this->_engine} DEFAULT CHARSET={$this->_charset} COLLATE={$this->_collate};";
        return $this->execute($syntax);
    }

    public function updateTable(orm_fieldset $fieldset) {
        //@todo goodzsq updatetable syntax
        /*
          ALTER TABLE `posts`
          CHANGE `title` `title` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
          CHANGE `status` `status` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'draft'
         */
        $syntax = "ALTER TABLE `" . $fieldset->schema() . "` \n";
        // Columns
        $syntax .= implode(",\n", $columnsSyntax);


        // Keys...
        $ki = 0;
        $usedKeyNames = array();
        foreach ($formattedFields as $fieldName => $fieldInfo) {
            // Determine key field name (can't use same key name twice, so we  have to append a number)
            $fieldKeyName = $fieldName;
            while (in_array($fieldKeyName, $usedKeyNames)) {
                $fieldKeyName = $fieldName . '_' . $ki;
            }
            // Key type
            if ($fieldInfo['primary']) {
                $syntax .= ",\n PRIMARY KEY(`" . $fieldName . "`)";
            }
            if ($fieldInfo['unique']) {
                $syntax .= ",\n UNIQUE KEY `" . $fieldKeyName . "` (`" . $fieldName . "`)";
                $usedKeyNames[] = $fieldKeyName;
                // Example: ALTER TABLE `posts` ADD UNIQUE (`url`)
            }
            if ($fieldInfo['index']) {
                $syntax .= ",\n KEY `" . $fieldKeyName . "` (`" . $fieldName . "`)";
                $usedKeyNames[] = $fieldKeyName;
            }
        }

        // Extra
        $syntax .= ";";
        return $syntax;
    }

    public function syntaxField(field_type_base $field) {
        if (!isset($this->_fieldTypeMap[$field->type])) {
            throw new phpDataMapper_Exception("Field type {$field->type} not supported");
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

    public function syntaxUpdateField(field_type_base $field, $add = false) {
        return ( $add ? "ADD COLUMN " : "MODIFY " ) . $this->syntaxField($field);
    }

}

