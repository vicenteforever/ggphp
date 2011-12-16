<?php

/**
 * @author goodzsq@gmail.com
 * session存储适配器器
 */
class nosql_session_adapter implements nosql_adapter {

    private $_group;

    function __construct($group) {
        core_session::start();
        $this->_group = $group;
    }

    function load($key) {
        if (isset($_SESSION[$this->_group][$key])) {
            return unserialize($_SESSION[$this->_group][$key]);
        }
        return null;
    }

    function save($key, $data) {
        $_SESSION[$this->_group][$key] = serialize($data);
    }

    function delete($key) {
        unset($_SESSION[$this->_group][$key]);
    }

}