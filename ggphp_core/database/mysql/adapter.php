<?php

/**
 * mysql数据库操作
 * @package database
 * @author goodzsq@gmail.com
 */
class database_mysql_adapter {

    private $_dbh;

    function __construct($server, $username, $password, $dbname, $charset) {
        $this->connect($server, $username, $password, $dbname, $charset);
    }

    function dbh() {
        return $this->_dbh;
    }

    private function connect($server, $username, $password, $dbname, $charset) {
        $dbh = @mysql_connect($server, $username, $password);
        if (!$dbh) {
            throw new Exception("database fail");
        }
        mysql_select_db($dbname);
        if (!empty($charset)) {
            mysql_query("SET NAMES {$charset}");
        }
        $this->_dbh = $dbh;
    }

    function query($sql) {
        return new database_mysql_result(mysql_query($sql));
    }

    function cacheQuery($sql) {
        static $result;
        if (!isset($result[$sql])) {
            $result[$sql] = $this->query($sql);
        }
        return $result[$sql];
    }

}

