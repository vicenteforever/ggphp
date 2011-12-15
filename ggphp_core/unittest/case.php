<?php

/**
 * unit test
 * @package util
 * @author Administrator
 */
class unittest_case {
	
	/**
	 * 测试结果
	 * @var array
	 */
	private $_result = array();
	/**
	 * 当前测试模块
	 * @var string 
	 */
	private $_module = '';
	
	function testModule($module, $desp='') {
		$moduleName = "{$module}_test";
		$methods = get_class_methods($moduleName);
		$this->_result[$module] = array();
		$this->_module = $module;
		if (is_array($methods)) {
			$obj = new $moduleName();
			foreach ($methods as $method) {
				if (strpos($method, 'test_') === 0) {
					$this->_result[] = $obj->$method();
				}
			}
		}
	}

	function assert($result, $msg) {
		if($result==true){
			$rs = 'pass';
		}
		else{
			$rs = 'fail';
		}
		$this->_result[$this->_module][] = array($rs=>$msg);
	}

	function assertEqual($a, $b, $msg) {
		$result = ($a==$b)?true:false;
		$this->assert($result, $msg);
	}

	function report() {
		return print_r($this->_result, true);
	}

}

?>
