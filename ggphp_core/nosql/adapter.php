<?php

interface nosql_adapter {

    function __construct($group);

    function load($key);

    function save($key, $value);

    function delete($key);
    
}