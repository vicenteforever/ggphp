<?php

/**
 * @author goodzsq@gmail.com
 * memcache存储适配器器
 */
class nosql_memcache extends nosql_object {

    /**
     * @var memcache
     */
    private $_memcache;

    function __construct($source) {
        @list($this->_source, $server) = explode('@', $source);
        $this->_memcache = memcache($server);
        $this->load();
    }

    function load() {
        if ($this->_memcache) {
            $this->_data = $this->_memcache->get($this->_source);
        }
        else{
            $this->_data = null;
        }
    }

    function save() {
        if ($this->_memcache) {
            $this->_memcache->set($this->_source, $this->_data);
        }
    }

    function delete() {
        if ($this->_memcache) {
            $this->_memcache->delete($this->_source);
        }
    }

}