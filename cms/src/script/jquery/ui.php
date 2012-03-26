<?php

/**
 * jquery ui组件封装
 * @package script
 * @author goodzsq@gmail.com
 */
class script_jquery_ui {

    //@todo goodzsq jquery ui wrapper
    const ver = '1.8.18';

    public function __construct() {
        response()->addScriptFile('js/jquery.js');
        response()->addCssFile('js/jquery-ui/jquery-ui-' . self::ver . '.custom.min.js');
        response()->addCssFile('js/jquery-ui/css/ui-lightness/jquery-ui-' . self::ver . '.custom.css');
    }

    /**
     * 选取日期 
     */
    public function datepicker(){
        
    }
    
    /**
     * 自动完成 
     */
    public function autocomplete(){
        
    }
    
    /**
     * 进度条 
     */
    public function progressbar(){
        
    }
    
    /**
     * 对话框 
     */
    public function dialog(){
        
    }
    
}

