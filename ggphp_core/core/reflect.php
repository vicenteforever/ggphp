<?php

/**
 * php反射对象
 * @package core 
 * @author goodzsq@gmail.com
 */
class core_reflect {

    private $_reflect;

    /**
     * reflection class
     * @param string $className 
     */
    function __construct($className) {
        $this->_reflect = new ReflectionClass($className);
    }

    /**
     * get all method
     * @return array();
     */
    function methods($filter=ReflectionMethod::IS_PUBLIC) {
        return $this->_reflect->getMethods($filter);
    }

    function doc($method=null) {
        if (!isset($method)) {
            $doc = $this->_reflect->getDocComment();
        } else {
            $doc = $this->_reflect->getMethod($method)->getDocComment();
        }

        $doc = trim(preg_replace("/(^\s*\/\*\*?)|(^\s*\*\/)|(^\s*\*)|(^.*@.*$)/m", '', $doc));
        $lines = explode("\n", $doc);
        return $lines[0];
    }

}
