<?php

/**
 * 菜单项
 * @package menu
 * @author goodzsq@gmail.com
 */
class menu_item extends struct_tree {

    public function __construct($id, $title, $url='#') {
        parent::__construct($id);
        $this->title = $title;
        $this->url = $url;
    }

}
