<?php

/**
 * 路径操作
 * @package util
 * @author $goodzsq@gmail.com
 */
class util_dir {

    /**
     * 列出指定路径中的子目录
     * @param string $dir
     * @return array 
     */
    static function subdir($dir) {
        $result = array();
        if (is_dir($dir)) {
            $list = scandir($dir);
            foreach ($list as $file) {
                if ($file != '.' && $file != '..') {
                    $path = $dir . DS . $file;
                    if (is_dir($path)) {
                        $result[$file] = $path;
                    }
                }
            }
        }
        return $result;
    }

    /**
     * 删除目录树
     * @param string $dir 指定要删除的目录名称
     */
    static function remove($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . DS . $object) == "dir") {
                        self::remove($dir . DS . $object);
                    } else {
                        unlink($dir . DS . $object);
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    /**
     * 列出目录树结构
     * @param string $dir 目录名称
     * @param string $filter 正则表达式过滤器
     * @return array 
     */
    static function tree($dir, $filter = null) {
        $result = array();
        if (is_dir($dir)) {
            $list = scandir($dir);
            foreach ($list as $file) {
                if ($file != '.' && $file != '..') {
                    $path = $dir . DS . $file;
                    if (is_dir($path)) {
                        $result[$file] = self::tree($path, $filter);
                    } else {
                        if (isset($filter)){
                            if (preg_match("/$filter/", $file)) {
                                $result[$file] = $path;
                            }
                        } else {
                            $result[$file] = $path;
                        }
                    }
                }
            }
        }
        return $result;
    }

}