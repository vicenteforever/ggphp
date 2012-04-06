<?php

/**
 * 布局
 * @package advice
 * @author goodzsq@gmail.com
 */
class advice_layout extends advice_base {

    public function __construct() {
        self::use_blueprint();
    }
    
    public function after($class, $method, $args, $return) {
        $config = config('advice', $class);
        if (isset($config[$method]['layout'])) {
            return self::render($config[$method]['layout'], $return);
        } else {
            return $return;
        }   
    }

    public function setting() {
        return array('name' => 'layout', 'label' => '布局', field => 'string');
    }

    static public function render($layoutName, $value){
        $layout = config("layout/$layoutName");

        $buf = "<div class='container'>\n";
        foreach($layout as $key=>$row){
            if($row['content']=='[content]'){
                $row['content'] = $value;  
            }
            //print_r($row['content']);
            $widget = new layout_model($row);
            $buf .= $widget->render() . "\n";
        }
        $buf .= "</div>\n";
        return $buf;
    }
    
    /**
     * 采用bluepring布局框架 
     */
    static public function use_blueprint() {
        $basepath = config('app', 'common_path') .'css/blueprint';
        response()->addCssFile("$basepath/screen.css", 'screen, projection');
        response()->addCssFile("$basepath/print.css", 'print');
        response()->addCssFile("$basepath/ie.css", 'screen, projection', 'lt IE 8');
    }

}

