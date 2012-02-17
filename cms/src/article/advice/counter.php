<?php

/**
 * 文档增强方法
 * @package article
 * @author goodzsq@gmail.com
 */
class article_advice_counter extends advice_base {
    public function after($name, $args, $return) {
        //echo 'article counter after';
        return $return;
    }
    
    public function before($name, $args) {
        //echo 'article counter before';
    }
    
    public function except($name, $args, $except) {
        //echo 'article counter exception';
    }
}

?>
