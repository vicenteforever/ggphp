<?php

/**
 * 菜单项
 * @package menu
 * @author goodzsq@gmail.com
 */
class menu_item extends struct_tree1 {

    private $_title;

    public function __construct($id, $title) {
        parent::__construct($id);
        $this->_title = $title;
    }
    
    public function title(){
        return $this->_title;
    }
    
    public function renderHtml() {
        $buf = "<li>{$this->_title}";
        if($this->hasChildren()){
            $buf .= "<ul>";
            foreach($this->getChildren() as $key=>$child){
                $buf .= $child->renderHtml();
            }
            $buf .= "</ul>";
        }
        $buf .="</li>";
        return $buf;
    }
    
    public function data(){
        $data['title'] = $this->_title;
        if($this->hasChildren()){
            foreach($this->getChildren() as $key=>$value){
                $data['children'][$key] = $value->data();
            }
        }
        return $data;
    }

}
