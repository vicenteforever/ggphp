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
    function index(){
        return html(block('menu', 'main'));
    }
    
    function test(){
        return html('test');
    }
}

?>
