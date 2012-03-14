<?php

/**
 * model
 * @package menu
 * @author goodzsq@gmail.com
 */
class menu_model {

    static public function main() {
        $tree = new menu_item('a', 'A');
        $a1 = new menu_item('b', 'B');
        $a2 = new menu_item('c', 'C');
        $a3 = new menu_item('d', 'D');
        $a1->addChildren($a2);
        $a2->addChildren($a3);
        
        $index = new menu_item('index', '首页', base_url());
        $admin = new menu_item('admin', '后台管理', base_url().'admin');
        $help = new menu_item('help', '帮助', 'help');

        $tree->addChildren($index);
        $tree->addChildren($admin);
        $tree->addChildren($help);
        $tree->addChildren($a1);

        //$a->changeParent($a21);
        return $tree;
    }
    
    static public function admin(){
        $tree = new menu_item('admin_root', '管理菜单');
        $baseurl = base_url() . 'admin';
        foreach(core_module::all() as $module=>$path){
            if(class_exists("{$module}_admin")){
                $item = new menu_item($module, $module, "$baseurl/$module");
                $tree->addChildren($item);
            }
        }
        return $tree;
    }

}
