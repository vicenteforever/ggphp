<?php

/**
 * 站点名称
 * @package
 * @author Administrator
 */
class default_controller {
    
    /**
     * 首页
     */
    function do_index(){
        $buf = view(block('menu', 'main', 'left'));
        return $buf;
    }
    
    function do_test(){
        return util_string::base36('我是谁是我');
    }
}
