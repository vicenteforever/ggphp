<?php

/**
 * input filter
 *
 * @author goodzsq@gmail.com
 */
class util_filter {

    /**
     * get textile object
     * @staticvar Textile $textile
     * @return Textile 
     */
    static function textile() {
        static $textile;
        if(!isset($textile)){
            require_once(GG_DIR.'/lib/textile/classTextile.php');
            $textile = new Textile();
        }
        return $textile;
    }

}

?>
