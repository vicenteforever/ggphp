<?php

/**
 * 创建flash对象
 * @package widget
 * @author goodzsq@gmail.com
 */
class widget_swfobject extends widget_base {

    /**
     * 构造函数
     * @param string $id
     * @param mixed $data
     * @example widget_swfobject('id', '/kkeyboard.swf')
     * @example widget_swfobject('id', array('swf'=>'/keyboard.swf', 'flashvars'=>array('var1'=>'aa', 'var2'=>'bb')))
     */
    public function __construct($id, $data) {
        $this->_id = "swfobject_$id";

        if (is_array($data)) {
            $this->_data = $data;
        } else if (is_string($data)) {
            $this->_data = array('swf' => $data);
        }
    }

    public function theme_default() {
        $selector = '#' . $this->_id;
        jquery_plugin()->swfobject($selector, $this->_data);
        return "<a id='{$this->_id}' href='{$this->_data['swf']}'>{$this->_data['swf']}</a>";
    }

}

