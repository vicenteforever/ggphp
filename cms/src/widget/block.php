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

    public function theme_default() {
        $selector = '#' . $this->_id;
        $style = <<<EOF
.block {width:200px;height:200px;border:1px solid red}
EOF;
        response()->addCssInline($style);
        return "<div id='{$this->_id}' class='block' ><h1>{$this->_title}</h1>{$this->_data}</div>\n";
    }

}

?>
