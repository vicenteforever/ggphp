<?php

/**
 * 基于PDO的数据库适配器
 * @package orm
 * @author goodzsq@gmail.com
 */
abstract class orm_adapter_pdo {

    /** @var PDO PDO数据库对象 */
    protected $_connection;

    abstract public function getIndexFromTable($table);

    abstract public function getColumnsFromTable($table);

    abstract public function syntaxField(field_type_base $field);

    abstract public function createDatabase($source);

    abstract public function createTable(orm_fieldset $fieldset);

    abstract public function updateTable(orm_fieldset $fieldset);

    abstract public function tableExists($table);

    /**
     * 分页查询
     * @return PDOStatement 
     */
    abstract public function queryLimit($sql, $params, $limit, $offset);

    /**
     * 获取一个pdo数据库连接对象并缓存
     * @staticvar PDO $pdo 数据库连接对象
     * @param string $dsn 数据源名称
     * @param string $username 用户名
     * @param string $password 用户密码
     * @param array $options 连接选项
     * @return \PDO 
     */
    static public function connect($dsn, $username, $password, $options) {
        static $pdo;
        $identity = "{$dsn}_{$username}";
        if (!isset($pdo[$identity])) {
            $pdo[$identity] = new PDO($dsn, $username, $password, $options);
        }
        return $pdo[$identity];
    }

    /**
     * 构造函数
     * @param string $dsn 数据源名称
     * @param string $username 用户名
     * @param string $password 用户密码
     * @param array $options 连接选项
     */
    public function __construct($dsn, $username, $password, $options) {
        $this->_connection = self::connect($dsn, $username, $password, $options);
    }

    /**
     * 获取连接对象
     * @return \PDO 
     */
    public function connection() {
        return $this->_connection;
    }

    /**
     * 执行sql语句
     * @param string $sql
     * @param array $params
     * @return boolean
     * @throws Exception 
     */
    public function execute($sql, $params = null) {
        $stmt = $this->connection()->prepare($sql);
        if ($stmt) {
            if ($stmt->execute($params)) {
                app()->log("SQL语句执行成功:$sql", $params, core_app::LOG_INFO);
                return true;
            } else {
                app()->log("SQL语句执行失败:$sql", $stmt->errorInfo(), core_app::LOG_ERROR);
                return false;
            }
        } else {
            app()->log("数据库准备失败:$sql", core_app::LOG_ERROR);
            return false;
        }
    }

    /**
     * 创建新纪录
     * @param string $source
     * @param array $data 
     * @return string 新纪录的id，失败返回false
     */
    public function create($source, $data) {
        $binds = $this->binds($data);
        $fields = implode(', ', array_keys($data));
        $params = implode(', ', array_keys($binds));
        $sql = "INSERT INTO $source ( $fields ) VALUES ( $params )";

        if ($this->execute($sql, $binds)) {
            return $this->connection()->lastInsertId();
        } else {
            return false;
        }
    }

    /**
     * 查询语句
     * @param string $sql
     * @return PDOStatement 
     */
    public function query($sql, $params = null) {
        $stmt = $this->connection()->prepare($sql);
        if ($stmt) {
            if ($stmt->execute($params)) {
                app()->log("SQL查询语句执行成功:[$sql] 返回行数:".$stmt->rowCount(), $params, core_app::LOG_INFO);
                return $stmt;
            } else {
                app()->log("SQL查询语句执行失败:$sql", $stmt, core_app::LOG_ERROR);
                return false;
            }
        } else {
            app()->log("数据库准备失败:$sql", core_app::LOG_ERROR);
            return false;
        }
    }

    /**
     * 更新记录
     * @param string $source
     * @param array $data
     * @param mixed $where array or string
     * @return boolean 
     */
    public function update($source, $data, $where) {
        $binds = $this->binds($data);
        $keys = array_keys($data);
        $fields = implode(', ', $keys);
        foreach ($keys as $k) {
            $params[] = "$k = :$k";
        }
        $setvalue = implode(' , ', $params);
        $clauses = array();
        if (is_array($where)) {
            foreach ($where as $k => $v) {
                $binds[':w_' . $k] = $v;
                $clauses[] = "$k = :w_$k";
            }
            $clause = implode(' AND ', $clauses);
        } else {
            $clause = $where;
        }
        $sql = "UPDATE $source SET $setvalue WHERE $clause";
        return $this->execute($sql, $binds);
    }

    /**
     * 删除记录
     * @param string $source
     * @param mixed $where
     * @return boolean 
     */
    public function delete($source, $where) {
        $binds = array();
        if (is_array($where)) {
            foreach ($where as $k => $v) {
                $binds[':w_' . $k] = $v;
                $clauses[] = "$k = :w_$k";
            }
            $clause = implode(' AND ', $clauses);
        } else {
            $clause = $where;
        }
        $sql = "DELETE FROM $source WHERE $clause";
        return $this->execute($sql, $binds);
    }

    /**
     * 重建表
     * @param string $table
     * @param orm_fieldset $fieldset 
     * @return boolean
     */
    public function migrate(orm_fieldset $fieldset) {
        $table = $fieldset->table();
        if (!$this->tableExists($table)) {
            return $this->createTable($fieldset);
        } else {
            return $this->updateTable($fieldset);
        }
    }

    /**
     * 清空表
     * @param string $source
     * @return boolean 
     */
    public function truncateTable($source) {
        $sql = "TRUNCATE TABLE " . $source;
        return $this->execute($sql);
    }

    /**
     * 删除表
     * @param string $source 表名称
     * @return boolean 
     */
    public function dropTable($source) {
        $sql = "DROP TABLE $source";
        return $this->execute($sql);
    }

    /**
     * 删除数据库
     * @param string $source 数据库名称
     * @return boolean 
     */
    public function dropDatabase($source) {
        $sql = "DROP DATABASE $source";
        return $this->execute($sql);
    }

    /**
     * 准备绑定参数变量
     * @param type $data 
     */
    protected function binds($data) {
        $result = array();
        foreach ($data as $key => $val) {
            $result[':' . $key] = $val;
        }
        return $result;
    }

}

