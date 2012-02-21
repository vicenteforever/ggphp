<?php

/**
 * 文章管理
 * @package article
 * @author goodzsq@gmail.com
 */
class article_admin {
    
    function admin_add(){
        $article = new article_model();
        echo trace($article->get(123));
    }
}
