<?php
/**
 * 实现REST控制器
 * @package rest
 * @author goodzsq@gmail.com
 */
class rest_controller {
    
    public function do_index(){
        $resources = param(0);
        $id = param(1);
        $method = core_request::method();
        return $this->test(get_defined_vars());
    }
    
    private function test($vars){
        return trace($vars);
    }
}
