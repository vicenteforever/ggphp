<?php

/**
 * 引入 css框架
 * @package
 * @author goodzsq@gmail.com
 */
class theme_css {
    
    public function blueprint() {
        response()->addCssFile('css/blueprint/screen.css', 'screen, projection');
        response()->addCssFile('css/blueprint/print.css', 'print');
        response()->addCssFile('css/blueprint/ie.css', 'screen, projection', 'lt IE 8');
    }
    

}

