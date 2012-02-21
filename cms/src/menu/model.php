<?php

/**
 * 导航菜单模型
 * @package menu
 * @author goodzsq@gmail.com
 */
class menu_model {

    private $_data;
    private $_tree;
    private $_level;
    
    function __construct($menuName) {
        $this->_data = config('menu', $menuName);
        $this->_tree = new struct_tree(null, $this->_data);
    }

    function data() {
        return $this->_data;
    }
    
    function tree(){
        return $this->_tree;
    }
    
    function html($maxLevel=0){
        //return "<ul>".$this->render($this->_tree)."</ul>";
        $buf = '<ul>';
        foreach($this->_tree->getChildren() as $value){
            $buf .= $this->render($value, $maxLevel);
        }
        $buf .= '</ul>';
        return $buf;
    }
    
    private function render(struct_tree $node, $maxLevel=9, $level=0){
        if($level>$maxLevel) {
            return '';
        }
        if($node->isLeaf()){
            return "<li>{$node->title}</li>";
        }
        else{
            $buf = "<li>{$node->title}<ul>";
            foreach ($node->children() as $key=>$value){
                $buf .= $this->render($value, $maxLevel, $level+1);
            }
            $buf .= '</ul></li>';
            return $buf;
        }
    }

}
