<?php

/**
 * 菜单项
 * @package menu
 * @author goodzsq@gmail.com
 */
class menu_item extends struct_tree1 {
    
    private $_title;
    private $_link;
    
    public function __construct($key, $title) {
        $this->setKey($key);
        $this->_link = $link;
        $this->_title = $title;
    }
    
    public function render(){
        return '<li>{$this->_title}</li>';
    }
 
    
}

?>
