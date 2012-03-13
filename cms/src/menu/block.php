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
        $a = new menu_item('a', 'A');
        $a1 = new menu_item('b', 'B');
        $a2 = new menu_item('c', 'C');
        $a21 = new menu_item('d', 'D');

        $a->addChildren($a1);
        $a->addChildren($a2);
        $a2->addChildren($a21);

        //$a->changeParent($a21);
        return widget('menu', 'main', $a)->render();
    }
    
    /**
     * 二级菜单 
     */
    public function second(){
        
    }
    
    /**
     * 树状菜单 
     */
    public function tree(){
        return 'tree';
    }
}
