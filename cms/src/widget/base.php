<?php
/**
 * widget_base
 * @package widget
 * @author goodzsq@gmail.com
 */
class widget_base {
    /**
     * 数据
     * @var type
     */
    protected $_data;

    /**
     * 设置数据
     * @param mixed $data
     * @return \widget_base 
     */
    public function setData($data){
        $this->_data = $data;
        return $this;
    }
    
    public function style_default(){
        return '';
    }
    
    public function render($style='default'){
        $methodName = "style_{$style}";
        if(!method_exists($this, $methodName)){
            $methodName = 'style_default';
        }
        return $this->$methodName();
    }
}
