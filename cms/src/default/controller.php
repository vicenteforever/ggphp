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
        return html(block('menu', 'main'));
    }
    
    function do_test(){
        return html('test');
    }
}

?>
