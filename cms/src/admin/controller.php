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
            $content = core_module::admin($module, $method);
            return $content;
        }
    }

    /**
     * 重建表
     */
    function do_migrate() {
        $schema = param(0);
        try {
            $model = orm($schema);
            util_csrf::validate();
            $model->migrate();
            $model->debug();
            $result = $model->helper()->schema() . '表已重建';
        } catch (Exception $e) {
            $result = $model->debug();
            $result .= $e->getMessage();
        }
        return $result;
    }

    private function homepage() {
        $buf = widget('breadcrumb', 'adminmenu', menu_model::admin())->render();
        return $buf;
    }

}
