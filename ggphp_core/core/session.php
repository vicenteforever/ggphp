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
     * get session instance
     * @return core_session
     */
    static function instance() {
        static $instance = null;
        if (!isset($instance)) {
            //保证只运行一次session_start
            session_start();
            $instance = new self;
            $instance->check();
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

    /**
     * session的安全性检查
     */
    function check() {
        $user_agent = md5(core_request::ip() . $_SERVER['HTTP_USER_AGENT']);
        if (!isset($_SESSION['user_agent'])) {
            $_SESSION['user_agent'] = $user_agent;
        }
        //如果用户session ID是伪造
        if ($_SESSION['user_agent'] != $user_agent) {
            die('会话错误，请关闭浏览器重新打开页面');
        }
    }

}
