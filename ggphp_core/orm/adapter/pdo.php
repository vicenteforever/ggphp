<?php

/**
 * 基于PDO的数据库适配器
 * @package orm
 * @author goodzsq@gmail.com
 */
abstract class orm_adapter_pdo {

    /** @var PDO PDO数据库对象 */
    protected $_connection;
    
    /** @var string 数据库名称 */
    protected $_database;

    abstract public function getIndexFromTable($table);

    abstract public function getColumnsFromTable($table);

    abstract public function syntaxField(field_type_base $field);

    abstract public function createDatabase($source);

    abstract public function createTable(orm_fieldset $fieldset);

    abstract public function updateTable(orm_fieldset $fieldset);

    abstract public function tableExists($source);
    
    /**
     * 分页查询
     * @return PDOStatement 
     */
    abstract public function queryLimit($sql, $params, $numrow, $offset);

    /**
     * 根据配置文件获取一个pdo对象
     * @param string $config
     * @return \PDO 
     */
    static public function pdo($config) {
        static $pdo;
        if (!isset($pdo[$config])) {
            $configData = config('database', $config);
            $pdo[$config] = new PDO($configData['dsn'], $configData['username'], $configData['password'], $configData['options']);
        }
        return $pdo[$config];
    }

    /**
     * 构造函数，创建对象时自动创建pdo对象
     * @param stirng $config 数据库配置文件config/database.php的某个配置名称
     */
    public function __construct($config = 'default') {
        $configData = config('database', $config);
        $this->_database = $configData['database'];
        $this->_connection = self::pdo($config);
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
                app()->log(array('sql' => $sql, 'data' => $params), core_app::LOG_OK);
                return true;
            } else {
                app()->log($stmt, core_app::LOG_EXCEPTION);
                return false;
            }
        } else {
            app()->log('prepare fail:' . $sql, core_app::LOG_EXCEPTION);
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
                app()->log(array('sql' => $sql, 'data' => $params), core_app::LOG_OK);
                return $stmt;
            } else {
                app()->log($stmt, core_app::LOG_EXCEPTION);
                return false;
            }
        } else {
            app()->log('prepare fail:' . $sql, core_app::LOG_EXCEPTION);
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
     * @param string $source
     * @param array $fields 
     */
    public function migrate($source, array $fields) {
        if ($this->exists($source)) {
            $this->createTable($source, $fields);
        } else {
            $this->updateTable($source, $fields);
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

