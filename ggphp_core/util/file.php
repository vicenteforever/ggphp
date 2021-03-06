<?php

/**
 * 文件处理函数
 * @package util
 * @author goodzsq@gmail.com
 */
class util_file {

    /**
     * 获取文件扩展名
     * @param string $filename
     * @return string
     */
    static function ext($filename) {
        $pos = strrpos($filename, '.');
        if ($pos !== false) {
            return strtolower(trim(substr($filename, $pos + 1)));
        } else {
            return '';
        }
    }

    /**
     * 检查文件名称是否有效，不保护非法字符
     * @param string $filename
     * @return boolean
     */
    static function valid($filename) {
        /* don't allow .. and allow any "word" character \ / */
        return preg_match('/^(((?:\.)(?!\.))|\w)+$/', $filename);
    }

}