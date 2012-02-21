<?php

/**
 * AOP动态代理，对业务对象进行外部增强
 * @package core 
 */
class core_aop {

    /**
     * 目标对象
     * @var ClassObject 
     */
    private $_target;
    private $_targetClass;

    /**
     * AOP代理对象
     * @param type $target 代理目标对象
     */
    function __construct($target) {
        $this->_target = $target;
        $this->_targetClass = get_class($target);
    }
    
    function target(){
        return $this->_target;
    }

    static function getAdvisor($caller) {
        static $advisor = array();
        if (!isset($advisor[$caller])) {
            $config = config('advice');
            $result = array();
            foreach ($config as $pattern => $value) {
                if (preg_match($pattern, $caller)) {
                    $result = array_merge($result, $value['allow']);
                    $result = array_diff($result, $value['forbidden']);
                }
            }
            $advisor[$caller] = array_unique($result);
        }
        return $advisor[$caller];
    }

    static function getAdvice($name) {
        static $advice;
        $className = str_replace('::', '_advice_', $name);
        if (!isset($advice[$className])) {
            if (class_exists($className)) {
                $advice[$className] = new $className;
            } else {
                $advice[$className] = new advice_base;
            }
        }
        return $advice[$className];
    }

    function __call($methodName, $args) {
        if (method_exists($this->_target, $methodName)) {
            $caller = "{$this->_targetClass}::{$methodName}";
            //获取增强对象列表
            $advisor = self::getAdvisor($caller);
            //业务方法调用之前增强
            foreach ($advisor as $advice) {
                self::getAdvice($advice)->before($caller, $args);
            }

            //执行真正的业务方法
            try {
                $result = call_user_func_array(array($this->_target, $methodName), $args);
            } catch (Exception $except) {
                //发生异常时增强
                $result = null;
                foreach ($advisor as $advice) {
                    self::getAdvice($advice)->except($caller, $args, $except);
                }
            }

            //业务方法调用之后增强
            foreach ($advisor as $advice) {
                $result = self::getAdvice($advice)->after($caller, $args, $result);
            }

            //返回业务方法返回值
            return $result;
        } else {
            throw new Exception("method:{$methodName} not exists");
        }
    }

}
