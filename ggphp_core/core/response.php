<?php

/**
 * 浏览器的输出
 * @package core 
 * @author goodzsq@gmail.com
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

    public function addScriptFile($file) {
        $this->_script[$file] = abs_url($file);
    }

    public function addScriptInline($jsCode) {
        $this->_scriptInline[] = $jsCode;
    }

    public function script() {
        $buffer = "";
        foreach ($this->_script as $key => $value) {
            $buffer .= "<script type=\"text/javascript\" src=\"{$value}\"></script>\n";
        }
        $buffer .= "<script type=\"text/javascript\">\n";
        foreach ($this->_scriptInline as $key => $value) {
            $buffer .= $value . "\n";
        }
        $buffer .= "</script>\n";
        return $buffer;
    }

    /**
     * 添加css外部文件
     * @param string $url
     * @param string $media [screen projection print]
     * @param string $condition borwser test: "lt IE 8"
     */
    public function addCssFile($url, $media='screen, projection', $condition='') {
        $this->_css[$url] = array('url'=>abs_url($url), 'media'=>$media, 'condition'=>$condition);
    }

    public function addCssInline($cssStyle) {
        $this->_cssInline[] = $cssStyle;
    }

    public function css() {
        $buffer = "";
        foreach ($this->_css as $key => $value) {
            $css = "<link href=\"{$value['url']}\" rel=\"stylesheet\" type=\"text/css\" media=\"{$value['media']}\" />";
            if(!empty($value['condition'])){
                $css = "<!--[if {$value['condition']}]>$css<![endif]-->";
            }
            $buffer .= $css . "\n";
        }
        $buffer .= "<style>\n";
        foreach ($this->_cssInline as $key => $value) {
            $buffer .= $value . "\n";
        }
        $buffer .= "</style>\n";
        return $buffer;
    }

    static function html($data) {
        if (is_string($data)) {
            $controller = app()->getControllerName() . '_controller';
            $action = config('app', 'action_prefix') . '_' . app()->getActionName();
            //$title = reflect($controller)->doc();
            $title = reflect($controller)->doc($action);
            return view(array('title' => $title, 'content' => $data), 'html');
        }
    }
    
    static function text($data){
        return $data;
    }

    static function download($filename, $content) {
        header("Content-Disposition: attachment; filename=$filename");
        echo $content;
        exit;
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
    
    static function auto($data){
        return 'render auto';
    }

}