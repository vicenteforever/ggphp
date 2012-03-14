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
        return html($buf);
    }
    
    function do_test(){
        return html('test');
    }
}
