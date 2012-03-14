<?php

/**
 * 菜单区块
 * @package menu
 * @author goodzsq@gmail.com
 */
class menu_block {
    
    /**
     * 主菜单 
     */
    public function main(){
        $data = menu_model::main();
        return widget('menu', 'main', $data)->render();
    }
    
    /**
     * 面包屑
     */
    public function breadcrumb(){
        $data = menu_model::main();
        return widget('breadcrumb', 'main', $data)->render();
    }
    
    /**
     * 二级菜单 
     */
    public function second(){
        return '二级菜单';
    }
    
    /**
     * 树状菜单 
     */
    public function tree(){
        return 'tree';
    }
}
