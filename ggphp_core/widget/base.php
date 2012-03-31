<?php

/**
 * widget_base
 * @package widget
 * @author goodzsq@gmail.com
 */
abstract class widget_base {

    abstract public function theme_default();

    /**
     * id
     * @var string
     */
    protected $_id;

    /**
     * 数据
     * @var mixed 
     */
    protected $_data;

    /**
     * 构造器
     * @param string $id
     * @param mixed $data 
     */
    public function __construct($id, $data) {
        $this->_id = $id;
        $this->_data = $data;
    }

    /**
     * 输出
     * @param string $theme
     * @return string 
     */
    public function render($theme = null) {
        if (empty($theme)) {
            $theme = config('app', 'theme');
        }
        $methodName = "theme_{$theme}";
        if (!method_exists($this, $methodName)) {
            $methodName = 'theme_default';
        }
        return $this->$methodName();
    }

}
