<?php

/**
 * 文章模型
 * @package
 * @author goodzsq@gmail.com
 */
class article_model {
    
    public $id;
    
    
    private $_article;
    
    public function __construct() {
        
    }
    
    public function getId($id){
        return $this->_article->get($id);
    }
    
    public function getCatelog($cid){
        return $this->_article->query($sql);
    }
    
    public function delete($id){
        
    }

    
}

?>
