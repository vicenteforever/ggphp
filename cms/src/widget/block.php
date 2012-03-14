<?php

/**
 * block
 * @package widget
 * @author goodzsq@gmail.com
 */
class widget_block extends widget_base {

    private $_title = '';

    public function __construct($id, $data) {
        parent::__construct($id, $data);
        $this->_id = "block_{$id}_{$data}";
        $this->_title = self::getBlockTitle($id, $data);
        $this->_data = self::getBlockContent($id, $data);
    }

    static function getBlockTitle($moduleName, $methodName) {
        $blockName = "{$moduleName}_block";
        return reflect($blockName)->doc($methodName);
    }

    static function getBlockContent($moduleName, $methodName) {
        static $blockObject;
        $blockName = "{$moduleName}_block";
        if (!isset($blockObject[$blockName])) {
            $blockObject[$blockName] = new $blockName;
        }
        if (method_exists($blockObject[$blockName], $methodName)) {
            return $blockObject[$blockName]->$methodName();
        } else {
            return 'no block method';
        }
    }

    private function html($id, $title, $data, $css){
        if(!empty($title)){
            $title = "<h1>$title</h1>";
        }
        return "<div id='{$id}' class='block {$css}' >{$title}\n{$data}\n</div>\n";
    }
    
    
    public function theme_default() {
        return $this->html($this->_id, $this->_title, $this->_data, 'default');
    }
    
    public function theme_left(){
        return $this->html($this->_id, $this->_title, $this->_data, 'left');
    }

}
