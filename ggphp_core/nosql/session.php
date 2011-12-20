<?php

/**
 * @author goodzsq@gmail.com
 * session存储适配器器
 */
class nosql_session extends nosql_object {
    
    function load() {
        $source = $this->_source;
        $this->_data = session()->$source;
    }

    function save() {
        $source = $this->_source;
        session()->$source = $this->_data;;
    }

    function delete() {
        $source = $this->_source;
        session()->$source = null;
    }

}