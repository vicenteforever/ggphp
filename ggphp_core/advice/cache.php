<?php

/**
 * implement cache as html file
 * @package advice
 * @author goodzsq@gmail.com
 */
class advice_cache extends advice_base {
    
    public function after($name, $args, $return) {
        $file = APP_DIR . DS . str_replace('/', DS, path());
        //@todo: cache as html file
        return parent::after($name, $args, $return);
    }

}

?>
