<?php
/**
 * Description of default_controller
 * @package default
 * @author goodzsq@gmail.com
 */
class default_controller {
    
    function do_index(){
        //$basepath = config('app', 'common_path') .'css/blueprint';
        response()->addCssFile('test.css');
        response()->addScriptFile('jquery.js');
        echo html('hello world');
        abs_url($url);
    }
}
