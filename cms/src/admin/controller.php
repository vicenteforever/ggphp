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
            return html("$module 不存在");
        } else {
            //转发到_admin系列控制器
            if (empty($method)) {
                $method = 'index';
            }
            $content = core_module::admin($module, $method);
            return html($content);
        }
    }

    private function homepage() {
        $buf = widget('breadcrumb', 'adminmenu', menu_model::admin())->render();
        return html($buf);
    }

}
