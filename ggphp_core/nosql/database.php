<?php

/**
 * 数据库存储
 * @package nosql
 * @author goodzsq@gmail.com
 */
class nosql_database extends nosql_object {

    private $_dbh;
    private $_tablename = 'nosql';
    private $_insert;
    private $_update;
    private $_delete;

    /**
     * @var PDOStatement
     */
    private $_select;

    /**
     * 判断记录是否存在
     * @var bool
     */
    private $_sourceExist;

    function __construct($source) {
        @list($this->_source, $server) = explode('@', $source);
        $this->_dbh = pdo($server);
        $this->_update = $this->_dbh->prepare("UPDATE `{$this->_tablename}` SET `value`=:value WHERE `key`=:key");
        $this->_insert = $this->_dbh->prepare("INSERT INTO `{$this->_tablename}` (`key`, `value`) VALUES (:key, :value)");
        $this->_delete = $this->_dbh->prepare("DELETE FROM `{$this->_tablename}` WHERE `key`=:key");
        $this->_select = $this->_dbh->prepare("SELECT * FROM `{$this->_tablename}` WHERE `key`=:key");
        $this->load();
    }

    function load() {
        $this->_select->bindParam(':key', $this->_source);
        $this->_select->execute();
        $this->_data = null;
        $this->_sourceExist = false;
        foreach ($this->_select as $row) {
            $this->_data = @unserialize($row['value']);
            $this->_sourceExist = true;
            return;
        }
    }

    function save() {
        $value = serialize($this->_data);
        if ($this->_sourceExist) {
            $this->_update->bindParam(':key', $this->_source);
            $this->_update->bindParam(':value', $value);
            if(!$this->_update->execute()){
                app()->log('数据库错误', $this->_update->errorInfo(), core_app::LOG_ERROR);
            }
        } else {
            $this->_insert->bindParam(':key', $this->_source);
            $this->_insert->bindParam(':value', $value);
            if(!$this->_insert->execute()){
                app()->log('数据库错误', $this->_insert->errorInfo(), core_app::LOG_ERROR);
            }
        }
    }

    function delete() {
        $this->_delete->bindParam(':key', $this->_source);
        $this->_delete->execute();
    }

}