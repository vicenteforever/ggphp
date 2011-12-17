<?php

/**
 * core_session
 * @package core
 * @author goodzsq@gmail.com
 */
class core_session {

	/**
	 * session start only run once
	 * @staticvar int $start
	 * @return core_session
	 */
	function start() {
		static $start;
		if (!isset($start)) {
			$start = 1;
			session_start();
		}
		return $this;
	}

	/**
	 * session destroy
	 */
	function end() {
		session_destroy();
	}

	function __get($name) {
		if (isset($_SESSION[$name])) {
			return $_SESSION[$name];
		} else {
			return null;
		};
	}
	
	function __set($name, $value) {
		$_SESSION[$name] = $value;
	}
	
}

?>
