<?php

/**
 * 校验失败异常
 * @package 
 * @author $goodzsq@gmail.com
 */
class exception_validate extends Exception {
    
    private $_validateError;
    
    public function __construct(array $error) {
        $message = json_encode($error);
        parent::__construct($message, 0, null);
        $this->_validateError = $error;
    }
    
    public function getValidateError(){
        return $this->_validateError;
    }
    
}