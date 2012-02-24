<?php

/**
 * 后台管理
 * @package admin
 * @author goodzsq@gmail.com
 */
class admin_controller {
    
    /**
     * 后台管理
     * @return string 
     */
    function do_index(){
        $module = param(0);
        $method = param(1);
        if(empty($method)){
            $method = 'index';
        }
        if(!core_module::exists($module)){
            return html("$module 不存在");
        }else{
            $content = core_module::admin($module,$method);
            return html($content);
        }
    }
    
}
