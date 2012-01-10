<?php

/**
 * AOP动态代理，对业务对象进行外部增强
 * @package core 
 */
class core_aop {

    private $_className;
    private $_target;
    private $_advisorConfig = array();

    function __construct($className) {
        $this->_className = $className;
        $this->_target = new $className;
        $advice = config('advice', $className);
        if (!is_array($advice)) {
            $advice = config('advice', '*');
        }
        if (!is_array($advice)) {
            $advice = array();
        }
        $this->_advisorConfig = $advice;
    }

    function __call($methodName, $args) {
        $reflect = new ReflectionClass($this->_target);
        $dispatcher = $reflect->getMethod($methodName);
        if ($dispatcher->isPublic() && !$dispatcher->isAbstract()) {
            //获取增强列表
            $advisor = @$this->_advisorConfig[$methodName];
            if (!is_array($advisor)) {
                $advisor = $this->_advisorConfig['*'];
            }
            if (!is_array($advisor)) {
                $advisor = array();
            }

            //业务方法调用之前增强
            $caller = "{$this->_className}::{$methodName}";
            foreach ($advisor as $advice) {
                advice($advice)->before($caller, $args);
            }

            //执行真正的业务方法
            try {
                $result = $dispatcher->invoke($this->_target, $args);
            } catch (Exception $exc) {
                //发生异常时增强
                foreach ($advisor as $advice) {
                    advice($advice)->except($caller, $args, $except);
                }
            }

            //业务方法调用之后增强
            foreach ($advisor as $advice) {
                $result = advice($advice)->after($caller, $args, $result);
            }

            //返回业务方法返回值
            return $result;
        } else {
            throw new Exception("method:{$methodName} not exists");
        }
    }

}

