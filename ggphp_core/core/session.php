<?php

/**
 * core_session 单例模式
 * @package core
 * @author goodzsq@gmail.com
 */
class core_session {

    private function __construct() {
        
    }

    /**
     * return core_session
     * @return core_app
     */
    static function instance() {
        static $instance;
        if (!isset($instance)) {
            //保证只运行一次session_start
            session_start();
            $instance = new self;
        }
        return $instance;
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
        if ($value === null) {
            unset($_SESSION[$name]);
        } else {
            $_SESSION[$name] = $value;
        }
    }

}

?>
