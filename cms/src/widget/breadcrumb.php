<?php

/**
 * breadcrumb
 * @package widget
 * @author goodzsq@gmail.com
 */
class widget_breadcrumb extends widget_base {

    public function __construct($id, $data) {
        parent::__construct($id, $data);
        $this->_id = 'breadcrumb_'.$id;
    }
    
    private function html(struct_tree $data){
        $buf = "<ul id='{$this->_id}'>";
        foreach($data->getChildren() as $key=>$child){
            $buf .= "<li><a href='{$child->url}'>{$child->title}</a></li>";
        }
        $buf .= "</ul>";
        return $buf;
    }
    
    
    public function theme_default() {
        //@todo goodzsq breadcrumb
        return $this->html($this->_data);
    }
}
