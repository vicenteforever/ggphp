<?php

/**
 * sessionadapter
 * @package core
 * @todo session_set_save_handler adapter
 * @author goodzsq@gmail.com
 */
class core_sessionadapter {

    /**
     * nosql存储器
     * @var nosql_object
     */
    static $adapter;
    
    function open($save_path, $session_name) {
        return(true);
    }

    function close() {
        return(true);
    }

    function read($id) {
        return nosql(self::$adapter, 'session_'.$id);
    }

    function write($id, $sess_data) {
        $saver = nosql(self::$adapter, 'session_'.$id);
        $saver->data($sess_data);
        $saver->save();
        return true;
    }

    function destroy($id) {
        nosql(self::$adapter, 'session_'.$id)->delete();
        return true;
    }

    function gc($maxlifetime) {
        foreach (glob("$sess_save_path/sess_*") as $filename) {
            if (filemtime($filename) + $maxlifetime < time()) {
                @unlink($filename);
            }
        }
        return true;
    }

}

