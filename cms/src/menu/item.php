<?php

/**
 * 菜单
 * @package menu
 * @author goodzsq@gmail.com
 */
class menu_item extends util_tree {

    public $title;
    public $url;
    
    public function __construct($id, $title, $url='#') {
        parent::__construct($id);
        $this->title = $title;
        $this->url = $url;
    }

}
