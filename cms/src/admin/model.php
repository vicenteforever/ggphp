<?php

/**
 * model
 * @package
 * @author goodzsq@gmail.com
 */
class admin_model {

    static function menu() {
        $tree = new menu_item('root', '管理菜单');
        $module = core_module::all();
        foreach ($module as $key => $value) {
            $className = "{$key}_admin";
            if (class_exists($className)) {
                $info = new core_reflect($className);
                $title = $info->doc();
                $item = new menu_item($key, $title);
                $tree->addChildren($item);
            }
        }
        return $tree;
    }

}
