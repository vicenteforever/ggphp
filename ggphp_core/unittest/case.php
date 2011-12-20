<?php
/**
 * unit test
 * @package util
 * @author Administrator
 */
class unittest_case {

    /**
     * 测试结果
     * @var array
     */
    private $_result = array();

    /**
     * 当前测试模块
     * @var string 
     */
    private $_module = '';

    private $_pass = 0;
    private $_fail = 0;
    private $_total = 0;
    
    function testModule($module, $desp='') {
        $className = "{$module}_test";
        $methods = get_class_methods($className);
        $this->_result[$module] = array();
        $this->_module = $module;
        if (is_array($methods)) {
            $obj = new $className();
            foreach ($methods as $method) {
                if (strpos($method, 'test_') === 0) {
                    $doc = $method.'() '.reflect($className)->doc($method);
                    $this->_result[$this->_module][] = array('status' => '>>>', 'msg' => $doc);
                    $obj->$method();
                }
            }
        }
    }

    /**
     * check test is pass or fail
     * @param bool $result
     * @param type $msg 
     */
    function assert($result, $msg) {
        if ($result === true) {
            $status = 'pass';
            ++$this->_pass;
        } else {
            $status = 'fail';
            ++$this->_fail;
        }
        ++$this->_total;
        $this->_result[$this->_module][] = array('status' => $status, 'msg' => $msg);
    }

    function assertEqual($a, $b, $msg='') {
        if(empty($msg)){
            $msg = "[{$a}] == [{$b}]";
        }
        $this->assert(($a == $b), $msg);
    }
    
    function report() {
        //print_r($this->_result);return;
        if($this->_fail>0){
            $style = 'fail';
        }
        else{
            $style = 'pass';
        }
        $buf = '<div class="unittest">';
        $buf .= "\n  <div class='summary {$style}'>total test:{$this->_total} pass:{$this->_pass} fail:{$this->_fail}</div>";
        foreach($this->_result as $module=>$result){
            $buf .= "\n  <div id='module_{$module}'>";
            $buf .= "<div class='title'>=====模块测试：{$module}=====</div>";
            foreach($result as $row){
                $buf .= "\n    <div class='{$row['status']}'>{$row['status']}: {$row['msg']}</div>";
            }
            $buf .= "\n  </div>";
        }
        $buf .= "\n</div>";
        return $buf;
    }

}

?>
