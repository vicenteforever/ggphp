<?php

/**
 * html辅助生成函数
 * @package util
 * @author goodzsq@gmail.com
 */
class util_html {
    
    static function a($url, $text='', $alt='', $title=''){
        return "<a href='$url' alt='$alt' title='title'>$text</a>";
    }
}

?>
