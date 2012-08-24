<?php

/**
 * 连接管理对象资源
 * @package db
 * @author $goodzsq@gmail.com
 */
class db_manager implements rest_interface {

    private $_adapter;
    
    public function __construct($adapter) {
        $this->_adapter = $adapter;
    }

    public function delete($id) {
        
    }

    public function deleteAll() {
        
    }

    /**
     * 获取数据库连接资源
     * @param string $id 数据库连接配置
     * @return rest_interface
     */
    public function get($id) {
        static $object = null;
        if (!isset($object[$id])) {
            $className = "db_{$this->_adapter}_database";
            $object[$id] = new $className($id);
        }
        return $object[$id];
    }

    public function index($params) {
        
    }

    public function post($id, $data) {
        
    }

    public function put($id, $data) {
        
    }

    public function struct() {
        
    }

}