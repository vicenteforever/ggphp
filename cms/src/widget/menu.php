<?php

/**
 * 导航菜单
 * @package widget
 * @author goodzsq@gmail.com
 */
class widget_menu extends widget_base {

    public function __construct($id, $data) {
        parent::__construct($id, $data);
        $this->_id = "menu_$id";
    }

    public function theme_default() {
        $selector = "#{$this->_id}";
        jquery_plugin()->menu($selector);
        return $this->html();
    }

    private function html(){
        if(!$this->_data instanceof struct_tree){
            throw new Exception('widget_menu set_data param must be struct_tree');
        }
        $buf = "<ul id='{$this->_id}'>";
        foreach($this->_data->getChildren() as $key=>$child){
            $buf .= $this->htmlItem($child);
        }
        $buf .= "</ul>";
        return $buf;        
    }
    
    private function htmlItem(struct_tree $tree) {
        $buf = "<li><a href='{$tree->url}'>{$tree->title}</a>";
        if($tree->hasChildren()){
            $buf .= "<ul>";
            foreach($tree->getChildren() as $key=>$child){
                $buf .= $this->htmlItem($child);
            }
            $buf .= "</ul>";
        }
        $buf .="</li>";
        return $buf;
    }

}

?>
