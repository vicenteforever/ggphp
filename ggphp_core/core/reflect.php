<?php

/**
 * core_reflect
 * @package core
 * @author Administrator
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
	 *
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
		$doc = trim(preg_replace("/(^\s*\/\*\*?)|(^\s*\*\/)|(^\s*\*)/m", '', $doc));
		return $doc;
	}

}

?>
