<?php

/**
 * 后台管理
 * @package admin
 * @author goodzsq@gmail.com
 */
class admin_controller {

    /**
     * 后台管理
     */
    function do_index() {
        $module = param(0);
        $method = param(1);
        if (empty($module)) {
            return $this->homepage();
        }

        if (!core_module::exists($module)) {
            return "$module 不存在";
        } else {
            //转发到_admin系列控制器
            if (empty($method)) {
                $method = 'index';
            }
            $content = core_module::controller("{$module}_admin", $method);
            return $content;
        }
    }

    function do_migrate(){
        $method = param(0);
        array_shift($_REQUEST['arg']);
        return core_module::controller('controller_migrate', $method);
    }
    
    private function homepage() {
        $buf = widget('breadcrumb', 'adminmenu', menu_model::admin())->render();
        return $buf;
    }

}
