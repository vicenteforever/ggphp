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
     * @param string $moduleName
     * @return string 
     */
    static function path($moduleName) {
        static $path = array();
        if (!array_key_exists($moduleName, $path)) {
            $path[$moduleName] = APP_DIR . DS . 'src' . DS . $moduleName;
            if (!is_dir($path[$moduleName])) {
                $path[$moduleName] = GG_DIR . DS . $moduleName;
                if (!is_dir($path[$moduleName])) {
                    $path[$moduleName] = '';
                }
            }
        }
        return $path[$moduleName];
    }

    /**
     * 检测模块是否存在
     * @param string $moduleName
     * @return boolean 
     */
    static function exists($moduleName) {
        return self::path($moduleName) !== '';
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

    /**
     * 生成类代理对象并执行方法
     * @staticvar core_aop $object
     * @param string $className
     * @param string $method
     * @return mixed
     * @throws Exception 
     */
    static function call($className, $method) {
        static $object;
        if (!preg_match("/^[_0-9a-zA-Z]+$/", $className))
            throw new Exception('invalid controller:' . $className);
        if (!preg_match("/^[_0-9a-zA-Z]+$/", $method))
            throw new Exception('invalid action:' . $method);
        
        if(!class_exists($className)){
            return "$className 类不存在";
        }
        
        if (!isset($object[$className])) {
            $target = new $className();
            $proxy = new core_aop($target);
            $object[$className] = $proxy;
        } else {
            $proxy = $object[$className];
            $target = $proxy->target();
        }

        if (method_exists($target, $method)) {
            return call_user_func(array($proxy, $method));
        } else {
            return "$className::$method 方法不存在";
        }
    }

    /**
     * 执行模块的controller控制器方法
     * @param string $className
     * @param string $method
     * @return mixed 
     */
    static function controller($className, $method=null) {
        if(empty($method)){
            $method = 'index';
        }
        $method = "do_{$method}";
        return self::call($className, $method);
    }

}
