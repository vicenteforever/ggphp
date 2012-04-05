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

    static function getAdvice($name) {
        static $advice;
        //$className = str_replace('::', '_advice_', $name);
        $className = 'advice_'.$name;
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
            //获取增强对象列表
            $advisor = config('app', 'advice');
            //业务方法调用之前增强
            foreach ($advisor as $advice) {
                self::getAdvice($advice)->before($this->_targetClass, $methodName, $args);
            }        
            try {
                //执行真正的业务方法
                $result = call_user_func_array(array($this->_target, $methodName), $args);
            } catch (Exception $except) {
                //发生异常时增强
                $result = null;
                foreach ($advisor as $advice) {
                    self::getAdvice($advice)->except($this->_targetClass, $methodName, $args, $except);
                }
            }
            //业务方法调用之后增强
            foreach ($advisor as $advice) {
                $result = self::getAdvice($advice)->after($this->_targetClass, $methodName, $args, $result);
            }
            //返回业务方法返回值
            return $result;
        } else {
            throw new Exception("method:{$methodName} not exists");
        }
    }

}
