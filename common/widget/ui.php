<?php

/**
 * jquery ui组件封装
 * @package script
 * @author goodzsq@gmail.com
 */
class script_jquery_ui {

    const ver = '1.8.18';

    public function __construct() {
        $commonpath = config('app', 'common_path');
        response()->addScriptFile($commonpath . 'js/jquery.js');
        response()->addCssFile($commonpath . 'js/jquery-ui/jquery-ui-' . self::ver . '.custom.min.js');
        response()->addCssFile($commonpath . 'js/jquery-ui/css/ui-lightness/jquery-ui-' . self::ver . '.custom.css');
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

