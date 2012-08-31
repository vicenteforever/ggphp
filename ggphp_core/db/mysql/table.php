<?php

/**
 * 数据库表对象
 * 用于创建修改删除查询数据
 * @package db
 * @author $goodzsq@gmail.com
 */
class db_mysql_table implements rest_interface {

    private $_table;
    private $_dbh;

    public function __construct($dbh, $table) {
        $this->_dbh = $dbh;
        $this->_table = $table;
    }

    public function delete($id) {
        $clause = $this->getPrimaryClause($id);
        $sql = "DELETE FROM {$this->_table} WHERE $clause";
        return db_mysql_helper::exec($sql, $this->_dbh);
    }

    public function deleteAll() {
        $sql = "TRUNCATE TABLE {$this->_table}";
        return db_mysql_helper::exec($sql, $this->_dbh);
    }

    /**
     * 获取数据
     * @param type $id 
     * @return rest_interface
     */
    public function get($id) {
        $clause = $this->getPrimaryClause($id);
        $sql = "SELECT * FROM `{$this->_table}` WHERE {$clause}";
        return db_mysql_helper::queryArray($sql, $this->_dbh);
    }

    public function index($params = null) {
        if (isset($params)) {
            $clause = $params;
        } else {
            $clause = 'true';
        }
        $sql = "SELECT * FROM `{$this->_table}` WHERE $clause";
        return db_mysql_helper::queryArray($sql, $this->_dbh);
    }

    /**
     * 创建一条新纪录
     * @param stirng $id 主键的值
     * @param array $data 插入的数据
     * @return boolean 成功返回插入记录的id 失败返回false
     */
    public function post($id, $data) {
        $keys = array();
        $values = array();
        //如何数据类型是数组类型则进行json编码成字符串之后存储
        foreach ($data as $key => $value) {
            $keys[] = "`$key`";
            if(is_array($value)){
                $value = json_encode($value);
            }
            $values[] = "'" . addslashes($value) . "'";
        }
        $keys = implode(' , ', $keys);
        $values = implode(' , ', $values);
        $sql = "INSERT INTO `{$this->_table}` ($keys) VALUES ($values)";
        if (db_mysql_helper::exec($sql, $this->_dbh)){
            return mysql_insert_id($this->_dbh);
        }
        else{
            return false;
        }
    }

    public function put($id, $data) {
        $clause = $this->getPrimaryClause($id);

        $values = array();
        foreach ($data as $key => $value) {
            $values[] = "`$key`='" . addslashes($value) . "'";
        }
        $values = implode(' , ', $values);
        $sql = "UPDATE `{$this->_table}` SET $values WHERE $clause ";
        return db_mysql_helper::exec($sql, $this->_dbh);
    }

    public function struct() {
        
    }

    private function getPrimaryClause($id) {
        if (is_array($id)) {
            $clause = array();
            foreach ($id as $key => $value) {
                $clause[] = "$key = '$value'";
            }
            $where = implode(' AND ', $clause);
        } else {
            $primary = db_mysql_helper::getPrimary($this->_table, $this->_dbh);
            $where = "{$primary[0]} = '$id'";
        }
        return $where;
    }

}