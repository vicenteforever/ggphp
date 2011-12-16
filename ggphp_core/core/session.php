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
     */
    static function start() {
	static $start;
	if (!isset($start)) {
	    $start = 1;
	    session_start();
	}
    }

    /**
     * session destroy
     */
    static function end() {
	session_destroy();
    }

}

?>
