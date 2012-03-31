<?php

/**
 * 布局基础
 * @package layout
 * @author goodzsq@gmail.com
 */
class layout_base {

    private $_layout;
    private $_id = 'base';
    private $_name = '基础布局';
    private $_block = array(
        'header' => array(),
        'body' => array(),
        'footer' => array(),
    );

    public function __construct() {
        $data = array('class' => 'container');
        $this->_layout = new layout_model($this->_id, $this->_name, $data);
        
        $header = new layout_model('header', 'HEADER');
        $content = new layout_model('content', 'CONTENT');
        $footer = new layout_model('footer', 'FOOTER');
        
        $this->_layout->addChildren($header);
        $this->_layout->addChildren($content);
        $this->_layout->addChildren($footer);
    }

    public function getLayout() {
        return $this->_layout;
    }
    
    public function render(){
        
    }

}

