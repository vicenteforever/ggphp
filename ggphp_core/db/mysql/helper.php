<?php

/**
 * mysql数据库操作封装
 * @package 
 * @author $goodzsq@gmail.com
 */
class db_mysql_helper {

    static function exec($sql, $dbh) {
        app()->log('SQL EXECUTE:' . $sql);
        $rs = mysql_query($sql, $dbh);
        $error = mysql_error();
        if (empty($error)) {
            app()->log("SQL OK");
        } else {
            app()->log("SQL ERROR: $error", core_app::LOG_ERROR);
        }
        if($rs){
            return $rs;
        }
        else{
            throw new Exception(mysql_error($dbh));
        }
    }

    static function query($sql, $dbh) {
        app()->log('SQL QUERY:' . $sql);
        $rs = mysql_query($sql, $dbh);
        $error = mysql_error();
        if (empty($error)) {
            app()->log("SQL OK");
        } else {
            app()->log("SQL ERROR: $error", core_app::LOG_ERROR);
        }
        if($rs){
            return $rs;
        }
        else{
            throw new Exception(mysql_error($dbh));
        }
    }

    static function rsToArray($rs, $key = null) {
        $result = array();
        if (isset($key)) {
            while ($row = mysql_fetch_assoc($rs)) {
                $result[$row[$key]] = $row;
            }
        } else {
            while ($row = mysql_fetch_assoc($rs)) {
                $result[] = $row;
            }
        }
        return $result;
    }

    static function queryArray($sql, $dbh, $key = null) {
        $rs = self::query($sql, $dbh);
        return self::rsToArray($rs, $key);
    }

    static function getPrimary($table, $dbh) {
        static $primary = null;
        $identity = "$table@$dbh";
        if (!isset($primary[$identity])) {
            $sql = "SHOW INDEX FROM $table WHERE Key_name='PRIMARY'";
            $rs = self::query($sql, $dbh);
            $result = array();
            while ($row = mysql_fetch_assoc($rs)) {
                $result[] = $row['Column_name'];
            }
            $primary[$identity] = $result;
        }
        return $primary[$identity];
    }

}