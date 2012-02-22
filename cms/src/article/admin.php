<?php

/**
 * 文章管理
 * @package article
 * @author goodzsq@gmail.com
 */
class article_admin {
    
    private $_article;
    
    public function __construct() {
        $this->_article = orm('article');
    }
    
    function admin_migrate(){
        $this->_article->migrate();
        $this->_article->debug();
    }
    
    function admin_create(){
        $node = $this->_article->get();
        $node->title = 'hello world';
        $node->content = '我是谁是我';
        $this->_article->insert($node);
        $this->_article->debug();
    }
    
    function admin_query(){
        foreach($this->_article->all() as $row){
            echo trace($row);
        }
    }
    
    function admin_update(){
        $node = $this->_article->get(1);
        $node->title = 'testabcdefg';
        $this->_article->save($node);
        $this->_article->debug();
    }
    
    function admin_delete(){
        $id = param('id');
        $sql = "delete from {$this->_table} where id='$id'";
        return mydb()->sqlExec($sql);
    }
}
