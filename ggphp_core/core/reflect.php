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
     * 获取所有方法
     * @param int $filter
     * @return array
     */
    function methods($filter=ReflectionMethod::IS_PUBLIC) {
        return $this->_reflect->getMethods($filter);
    }

    /**
     * 获取文档信息
     * @param string $method 方法名称
     * @return string 提供方法参数时，返回方法文档信息，不提供参数返回类文档信息
     */
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
