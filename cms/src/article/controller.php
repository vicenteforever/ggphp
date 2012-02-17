<?php

/**
 * 文章
 * @package article
 * @author goodzsq@gmail.com
 */
class article_controller {
    /**
     * 主页
     * @return string 
     */
    function index(){
        return html(path());
    }
    
    /**
     * 新闻
     * @return type 
     */
    function news(){
        mydb();
        return html('news');
    }
    
    //private function //
}

?>
