<?php

/**
 * 浏览器的输出
 * @package core
 */
class core_response {

    private $_script = array();
    private $_scriptInline = array();
    private $_css = array();
    private $_cssInline = array();

    private function __construct() {
        //设为私有方法禁止构造新实例
    }

    static function instance() {
        static $instance;
        if (!isset($instance)) {
            $instance = new self;
        }
        return $instance;
    }

    public function addScriptFile($jsFile) {
        $this->_script[$jsFile] = $jsFile;
    }

    public function addScriptInline($jsCode) {
        $this->_scriptInline[] = $jsCode;
    }

    public function script() {
        $buffer = "";
        foreach ($this->_script as $key => $value) {
            $value = base_url() . $value;
            $buffer .= "<script type=\"text/javascript\" src=\"{$value}\"></script>\n";
        }
        $buffer .= "<script type=\"text/javascript\">\n";
        foreach ($this->_scriptInline as $key => $value) {
            $buffer .= $value . "\n";
        }
        $buffer .= "</script>\n";
        return $buffer;
    }

    public function addCssFile($cssFile) {
        $this->_css[$cssFile] = $cssFile;
    }

    public function addCssInline($cssStyle) {
        $this->_cssInline[] = $cssStyle;
    }

    public function css() {
        $buffer = "";
        foreach ($this->_css as $key => $value) {
            $value = base_url() . $value;
            $buffer .= "<link href=\"$value\" rel=\"stylesheet\" type=\"text/css\" />\n";
        }
        $buffer .= "<style>\n";
        foreach ($this->_cssInline as $key => $value) {
            $buffer .= $value . "\n";
        }
        $buffer .= "</style>\n";
        return $buffer;
    }

    static function html($title, $content) {
        if (!isset($title)) {
            $controller = app()->getControllerName() . '_controller';
            $action = config('app', 'action_prefix') . '_' . app()->getActionName();
            //$title = reflect($controller)->doc();
            $title = reflect($controller)->doc($action);
        }
        return view(array('title' => $title, 'content' => $content), 'html');
    }

    static function download($filename, $content) {
        header("Content-Disposition: attachment; filename=$filename");
        return $content;
    }

    static function error($errorMessage) {
        echo view(array('errorMessage' => $errorMessage), 'error');
        exit;
    }

    static function json($data) {
        return json_encode($data);
    }

    static function jsonp($data, $callback) {
        return $callback . '(' . json_encode($data) . ')';
    }

    static function redirect($url) {
        header("Location: {$url}");
        exit;
    }

    static function rss($data) {
        header("Content-type: text/xml");
        $buffer = '<?xml version="1.0" encoding="UTF-8"?>';
        $buffer .= '<rss version="2.0">';
        $buffer .= $data;
        $buffer .= '</rss>';
        return $buffer;
    }

    static function xml($data) {
        header("Content-type: text/xml");
        $buffer = '<?xml version="1.0" encoding="UTF-8"?>';
        $buffer .= $data;
        return $buffer;
    }

    static function gzip($data, $contenttype) {
        if (strstr($_SERVER["HTTP_ACCEPT_ENCODING"], "gzip")) {
            header("Content-Type: {$data['Content-Type']}");
            header("Content-Encoding: gzip");
            header("Vary: Accept-Encoding");
            header("Content-Length: " . strlen($data['content']));
            return $data;
        }
    }

}