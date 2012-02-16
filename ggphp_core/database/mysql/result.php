<?php

class database_mysql_result implements Countable, Iterator, ArrayAccess {

    private $_result;
    private $_numRows = 0; //查询结果集有多少行  
    private $_iterPos = 0; //当前迭代器遍历到的位置

    public function __construct($result) {
        $this->_result = $result;
        $this->_numRows = mysql_num_rows($this->_result);
    }

    public function count() {
        return $this->_numRows;
    }

    public function fetchAll() {
        if($this->_numRows<1){
            return array();
        }
        mysql_data_seek($this->_result, 0);
        $data = array();
        while ($row = mysql_fetch_assoc($this->_result)) {
            $data[] = $row;
        }
        return $data;
    }

    public function current() {
        return mysql_fetch_assoc($this->_result);
    }

    public function key() {
        return $this->_iterPos;
    }

    public function next() {
        $this->_iterPos++;
    }

    public function rewind() {
        $this->_iterPos = 0;
        mysql_data_seek($this->_result, 0);
    }

    public function valid() {
        return $this->_iterPos > -1 && $this->_iterPos < $this->_numRows;
    }

    public function offsetExists($offset) {
        return $offset > -1 && $offset < $this->_numRows;
    }

    public function offsetGet($offset) {
        mysql_data_seek($this->_result, 0);
        return mysql_fetch_assoc($this->_result);
    }

    public function offsetSet($offset, $value) {
        //do nothing
    }

    public function offsetUnset($offset) {
        //do nothing
    }

}

