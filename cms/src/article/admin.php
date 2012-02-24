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
    
    function admin_edit(){
        $id = param('id');
        $node = $this->_article->get($id);
        $url = url('admin', 'article', 'save');
        return $this->_article->helper()->form($url, $node);
    }
    
    function admin_save(){
        $id = param('id');
        if(empty($id)){
            $node = $this->_article->get();
            fill_data($node);
            $this->_article->insert($node);

        }
        else{
            $node = $this->_article->get(param('id'));
            fill_data($node);
            $this->_article->save($node);
        }
        $url = url('admin', 'article', 'index');
        echo $url;
        redirect($url);
    }

    function admin_delete(){
        $id = param('id');
        echo "delete $id";
    }    
    
    function admin_index(){
        $data = array();
        $url = url('admin', 'article', 'edit');
        $buf = util_html::a($url, '添加');
        foreach($this->_article->all() as $row){
            $param = array('id'=>$row->id);
            $url = url('admin', 'article', 'edit', $param);
            $edit = util_html::a($url, '编辑');
            $url = url('admin', 'article', 'delete', $param);
            $delete = util_html::a($url, '删除');
            $data[] = array_merge($row->toArray(), array("$edit $delete"));
        }
        return $buf . widget('table')->setData($data)->render();
    }
       
}
