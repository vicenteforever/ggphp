<?php

/**
 * html辅助生成函数
 * @package util
 * @author goodzsq@gmail.com
 */
class util_html {
    
    static function a($url, $text='', $attr=array()){
        $attribute = self::makeAttribute($attr);
        return "<a href='$url'$attribute>$text</a>";
    }
    
    static function p($content, $attr=array()){
        $attribute = self::makeAttribute($attr);
        return "<p$attribute>$content</p>";
    }
    
    static function div($content, $attr=array()){
        $attribute = self::makeAttribute($attr);
        return "<div$attribute>$content</div>";
    }
    
    static function span($content, $attr=array()){
        $attribute = self::makeAttribute($attr);
        return "<span$attribute>$content</span>";
    }
    
    static function img($src, $attr=array()){
        $attribute = self::makeAttribute($attr);
        return "<img src='$src'$attribute />";
    }
       
    private static function makeAttribute($attr){
        if(empty($attr)){
            return '';
        }
        $result = array();
        foreach ($attr as $key => $value) {
            $result[] = "$key='$value'";
        }
        return ' ' . implode(' ', $result);
    }
}
