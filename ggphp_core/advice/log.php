<?php

/**
 * 系统日志
 * @package advice
 */
class advice_log extends advice_base {

    public function after($class, $method, $args, $return) {
        app()->log("$class::$method end");
        return $return;
    }

    public function before($class, $method, $args) {
        app()->log("$class::$method start");
    }

    public function except($class, $method, $args, $except) {
        app()->log("$class::$method exception: " . $except->getMessage());
    }

}

?>
