<?php

/**
 * 核心应用程序类 单例模式
 * @package core
 */
class core_app {

    private $_controllerName;
    private $_actionName;
    private $_pageType;

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
                error('the router not allow:' . core_request::path());
            }
            $this->parseFromPath();
        } else {
            $this->parseFromParam();
        }
        $result = core_module::controller("{$this->_controllerName}_controller", $this->_actionName);
        $pageType = $this->getPageType();
        if (method_exists(core_response::instance(), $pageType)) {
            echo core_response::$pageType($result);
        }
        else{
            echo core_response::error("$pageType not exist");
        }
        $this->log('application end');
        if ($pageType == 'html') {
            $this->report();
        }
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
        $path = core_request::path();
        $path = str_replace('..', '', $path);
        list($path, $this->_pageType) = $this->getBasenameAndType($path);
        $_SERVER['PATH_INFO'] = $path;
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
     * 获取页面输出格式类型
     * @return string 
     */
    function getPageType() {
        return $this->_pageType;
    }

    /**
     * 设置页面输出格式类型(html json xml ...)
     * @param string $type 
     */
    function setPageType($type) {
        $this->_pageType = $type;
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

    /**
     * url重写
     * @return boolean 
     */
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

    /**
     * 分解字符串为基本名称和扩展名
     * @param type $str
     * @return type 
     */
    private function getBasenameAndType($str) {
        $pos = strrpos($str, '.');
        if ($pos === false) {
            $basename = $str;
            $ext = '';
        } else {
            $basename = substr($str, 0, $pos);
            $ext = substr($str, $pos + 1);
        }
        if (empty($ext)) {
            $ext = 'html';
        }
        return array($basename, $ext);
    }

    private function report() {
        $report = '<hr/>';
        if (!config('app', 'debug')) {
            $report = "程序运行状态只能在调试模式下运行";
        } else {
            $log = app()->log();
            $time = $log[0]['time'];
            foreach ($log as $k => $v) {
                $timespan = sprintf("%.4f", $v['time'] - $time);
                $time = $v['time'];
                $report .= "[{$timespan}] {$v['message']} <br/>";
            }
            $total = sprintf("%.4f", $time - $log[0]['time']);
            $report .= "程序运行时间:$total ms, memory:" . util_string::size_hum_read(memory_get_usage()) . " <br>";
            $report .= "<a href='" . base_url() . "unittest'>运行单元测试</a>";
            $report .= "url rewrite:" . core_request::isRewrite();
        }
        echo $report;
    }

}