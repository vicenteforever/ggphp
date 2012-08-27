<?php

/**
 * 文件存储
 * @package nosql
 * @author goodzsq@gmail.com
 */
class nosql_file extends nosql_object {

    public function filename() {
        return APP_DIR . DS . 'dbfile' . DS . $this->_source . '.txt';
    }

    public function load() {
        $filename = $this->filename();
        if (file_exists($filename)) {
            $this->_data = unserialize(file_get_contents($filename));
        } else {
            $this->_data = null;
        }
    }

    public function save() {
        $buf = serialize($this->_data);
        $fp = fopen($this->filename(), 'w');
        flock($fp, LOCK_EX);
        fputs($fp, $buf);
        flock($fp, LOCK_UN);
        fclose($fp);
    }

    public function delete() {
        $filename = $this->filename();
        if (file_exists(($filename))) {
            @unlink($filename);
        }
    }

}