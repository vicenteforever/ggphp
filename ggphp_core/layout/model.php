<?php

/**
 * 布局模型
 * @package layout
 * @author goodzsq@gmail.com
 */
class layout_model {

    public $name;
    public $label;
    public $span = 24;
    public $append = 0;
    public $prepend = 0;
    public $pull = 0;
    public $push = 0;
    public $last = false;
    public $colborder = false;
    public $border = false;
    public $class = '';
    public $content = ''; //内容

    public function __construct(array $data) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
    
    public function render(){
        $css = "span-{$this->span}";
        if($this->last){
            $css .= ' last';
        }
        if($this->border){
            $css .= ' border';
        }
        return "<div id='{$this->name}' class='$css'>{$this->content()}</div>";
    }
    
    public function content(){
        if(is_object($this->content)){
            
        }
        //if(is_string($var))
        return print_r($this->content, true);
    }

}

