<?php

/**
 * @author goodzsq@gmail.com
 * memcache存储适配器器
 */
class nosql_memcache_adapter implements nosql_adapter {

    private $_memcache;

    function __construct($server) {
        $this->_memcache = memcache($server);
    }

    function load($key) {
        if ($data = $this->_memcache->get($key)) {
            return $data;
        } else {
            return null;
        }
    }

    function save($key, $data) {
        $this->_memcache->set($key, $data);
    }

    function delete($key) {
        $this->_memcache->delete($key);
    }

}