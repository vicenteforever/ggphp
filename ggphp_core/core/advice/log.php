<?php

/**
 * 系统日志
 * @package advice
 */
class core_advice_log extends advice_base {

    public function after($name, $args, $return) {
        app()->log("$name end");
        return parent::after($name, $args, $return);
    }

    public function before($name, $args) {
        app()->log("$name start");
    }

    public function except($name, $args, $except) {

        app()->log("$name exception: " . $except->getMessage());
    }

}

?>
