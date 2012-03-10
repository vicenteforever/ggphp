<?php
/**
 * widget_base
 * @package widget
 * @author goodzsq@gmail.com
 */
abstract class widget_base {
    /**
     * id
     * @var string
     */
    protected $_id;
    /**
     * 数据
     * @var string 
     */
    protected $_data;

    /**
     * 设置数据
     * @param mixed $data
     * @return \widget_base 
     */
    public function setData($id, $data){
        $this->_id = $id;
        $this->_data = $data;
        return $this;
    }
    
    abstract public function style_default();
    
    public function render($style='default'){
        $methodName = "style_{$style}";
        if(!method_exists($this, $methodName)){
            $methodName = 'style_default';
        }
        return $this->$methodName();
    }
}
