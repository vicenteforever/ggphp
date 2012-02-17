<?php

/**
 * 核心应用程序类 单例模式
 * @package core
 */
class core_app {

    private $_controllerName;
    private $_actionName;

    private function __construct() {
        //设为私有方法禁止构造新实例
    }

    /**
     * return core_app single instance
     * @return core_app
     */
    static function instance() {
        static $instance;
        if (!isset($instance)) {
            $instance = new self;
        }
        return $instance;
    }

    /**
     * 程序执行流程
     */
    function start() {
        $this->log('application start');
        if (core_request::isRewrite()) {
            $url = $this->rewriteUrl();
            if (config('app', 'only_use_router') && empty($url)) {
                error('the router not allow:' . path());
            }
            $this->parseFromPath();
        } else {
            $this->parseFromParam();
        }
        $this->exec($this->_controllerName, $this->_actionName);
        $this->log('application end');
    }

    /**
     * 执行控制器方法
     * @param string $controllerName
     * @param string $actionName 
     */
    public function exec($controllerName, $actionName) {
        if (!preg_match("/^[_0-9a-zA-Z]+$/", $controllerName))
            throw new Exception('invalid controller:' . $controllerName);
        if (!preg_match("/^[_0-9a-zA-Z]+$/", $actionName))
            throw new Exception('invalid action:' . $actionName);

        $controllerName = $controllerName . '_controller';
        $actionName = config('app', 'action_prefix') . '_' . $actionName;
        $controller = new $controllerName;
        $proxy = new core_aop($controller);
        echo $proxy->$actionName();
    }

    /**
     * 解析从url中的GET方法传递过来的控制器和方法
     */
    private function parseFromParam() {
        $this->_controllerName = param('controller');
        if (empty($this->_controllerName))
            $this->_controllerName = config('app', 'default_controller');
        $this->_actionName = param('action');
        if (empty($this->_actionName))
            $this->_actionName = config('app', 'default_action');
    }

    /**
     * 从pathinfo中解析控制器和方法
     */
    private function parseFromPath() {
        $path = path();
        $path = str_replace('..', '', $path);
        $args = explode('/', $path);
        $defaultAction = config('app', 'default_action');
        $defaultController = config('app', 'default_controller');
        $action_prefix = config('app', 'action_prefix');
        //控制器和方法均为空 均设为默认值
        if (empty($args[0])) {
            $args = array($defaultController, $defaultAction);
        }
        //路径中的控制器存在 very good
        else if (class_exists("{$args[0]}_controller")) {
            if (empty($args[1])) {
                $args[1] = $defaultAction;
            } elseif (!method_exists($args[0] . '_controller', $action_prefix . '_' . $args[1])) {
                array_splice($args, 1, 0, $defaultAction);
            }
        }
        //args[0]不为空但不是控制器
        else {
            array_unshift($args, $defaultController);
            if (empty($args[1])) {
                $args[1] = $defaultAction;
            } elseif (!method_exists($args[0] . '_controller', $action_prefix . '_' . $args[1])) {
                array_splice($args, 1, 0, $defaultAction);
            }
        }

        $this->_controllerName = $args[0];
        $this->_actionName = $args[1];
        $_REQUEST['arg'] = array_slice($args, 2);
    }

    /**
     * 获取控制器名称
     * @return string 
     */
    function getControllerName() {
        return $this->_controllerName;
    }

    /**
     * 获取控制器方法
     * @return string 
     */
    function getActionName() {
        return $this->_actionName;
    }

    /**
     * 记录系统日志
     * @param string $message
     */
    function log($message = null) {
        static $log = array();
        if (isset($message)) {
            $log[] = array('time' => microtime(true), 'message' => $message);
        } else {
            return $log;
        }
    }

    private function rewriteUrl() {
        $path = core_request::path();
        $config = config('router');
        foreach ($config as $k => $v) {
            if (preg_match($k, $path, $match)) {
                $_SERVER['PATH_INFO'] = str_replace($match[0], $v, $path);
                return true;
            }
        }
        return false;
    }

}