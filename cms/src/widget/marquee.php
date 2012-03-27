<?php

/**
 * marquee
 * @package widget
 * @author goodzsq@gmail.com
 */
class widget_marquee extends widget_base {

    public function __construct($id, $data) {
        parent::__construct($id, $data);
        $this->_id = 'marquee_'.$id;
    }
    
    public function theme_default() {
        //behavior="scroll alternate slide " scrollamount="1" direction="up down left right" width="" height="" loop="3"
        $selector = '#'.$this->_id;
        jquery_plugin()->marquee($selector);
        return "<marquee id='{$this->_id}'>{$this->_data}</marquee>";
    }

}

