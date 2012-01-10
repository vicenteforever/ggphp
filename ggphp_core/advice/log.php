<?php

/**
 * 系统日志
 * @package advice
 */
class advice_log extends advice_base {

    public function after($name, $args, $return) {
        app()->log("$name end");
        return parent::after($name, $args, $return);
    }

    public function before($name, $args) {
        app()->log("$name start");
    }

    public function except($name, $args, $except) {
        app()->log("$name except: " . $except->getMessage());
    }

}

?>
