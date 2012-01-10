<?php

/**
 * 获取模块相关信息
 * @package core
 */
class core_module {

    /**
     * 获取所有模块列表
     * @staticvar array $modules
     * @return array
     */
    static function all() {
        static $modules;
        if (!isset($modules)) {
            $modules = array_merge(util_file::subdir(GG_DIR), util_file::subdir(APP_DIR . DS . 'src'));
        }
        return $modules;
    }

    /**
     * 获取模块所在路径
     * @staticvar array $path
     * @param string $module
     * @return string 
     */
    static function path($module) {
        static $path;
        if (!isset($path[$module])) {
            $path[$module] = APP_DIR . DS . 'src' . DS . $module;
            if (!is_dir($path[$module])) {
                $path[$module] = GG_DIR . DS . $module;
                if (!is_dir($path[$module])) {
                    $path[$module] = '';
                }
            }
        }
        return $path[$module];
    }

    /**
     * 获取模块控制器的所有行为列表
     * @staticvar array $action
     * @param string $module
     * @return array 
     */
    static function action($module) {
        static $action;
        if (!isset($action[$module])) {
            $controller = $module . '_controller';
            $methods = get_class_methods($controller);
            $action[$module] = array();
            if (is_array($methods)) {
                foreach ($methods as $method) {
                    if (strpos($method, config('app', 'action_prefix')) === 0) {
                        $action[$module][] = $method;
                    }
                }
            }
        }
        return $action[$module];
    }

}