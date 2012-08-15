<?php

/**
 * mysql数据库操作封装
 * @package database
 * @author goodzsq@gmail.com
 */
class database_mysql_db {

    private $_dbh;

    function __construct($server, $username, $password, $dbname, $charset) {
        $this->init($server, $username, $password, $dbname, $charset);
    }

    private function init($server, $username, $password, $dbname, $charset) {
        $dbh = @mysql_connect($server, $username, $password);
        if (!$dbh) {
            throw new Exception("database fail");
        }
        mysql_select_db($dbname);
        if (!empty($charset)) {
            mysql_query("SET NAMES {$charset}", $dbh);
        }
        $this->_dbh = $dbh;
    }
    
    /**
     * 执行SQL查询语句，发生错误时扔出异常
     * @param string $sql
     * @return resource 
     */
    function sql($sql){
        //$sql = mysql_escape_string($sql);
        $rs = mysql_query($sql, $this->_dbh);
        if($rs === false){
            throw new Exception('mysqlerror' . mysql_error($this->_dbh));
        }
        return $rs;
    }
    
    /**
     * 执行非查询语句，返回影响的行数
     * @param string $sql
     * @return integer 
     */
    function sqlExec($sql){
        $this->sql($sql);
        return mysql_affected_rows();
    }

    /**
     * 执行查询语句并返回结果集
     * @param string $sql
     * @return database_mysql_result 
     */
    function sqlQuery($sql) {
        $sql = mysql_escape_string($sql);
        $rs = $this->sql($sql);
        return new database_mysql_result($rs);
    }

    /**
     * 执行查询语句并缓存结果集
     * @staticvar array $result
     * @param string $sql
     * @return database_mysql_result 
     */
    function sqlQueryCache($sql) {
        static $result = null;
        if (!isset($result[$sql])) {
            $result[$sql] = $this->sqlQuery($sql);
        }
        return $result[$sql];
    }

}
