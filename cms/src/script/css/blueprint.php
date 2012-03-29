<?php

/**
 * 引入 blueprint css框架
 * @package
 * @author goodzsq@gmail.com
 */
class script_css_blueprint {
    
    public function __construct() {
        response()->addCssFile('js/blueprint/screen.css', 'screen, projection');
        response()->addCssFile('js/blueprint/print.css', 'print');
        response()->addCssFile('js/blueprint/ie.css', 'screen, projection', 'lt IE 8');
    }
    
    public function addLayout(){
        return "<div class='.container'></div>";
    }
}

