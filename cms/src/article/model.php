<?php

/**
 * 文章模型
 * @package
 * @author goodzsq@gmail.com
 */
class article_model {
    //array('name'=>'id', 'label'=> 'ID', 'field'=>'int', 'primary'=>true, 'serial'=>true),
    //array('name'=>'name', 'label'=> '用户名称', 'field'=>'string', 'required'=>true, 'length'=>20),
    //array('name'=>'password', 'label'=> '用户密码', 'field'=>'password'),
    private $_fields;
    public function __construct() {
    }
    
    public function addField($name, $label, $fieldType, $fieldConfig=array()){
        $fieldClass = "field_{$fieldType}";
        $field = new $fieldClass;
        $field->name = $name;
        $field->label = $label;
        if(is_array($fieldConfig)){
            foreach($fieldConfig as $k=>$v){
                $field->$k = $v;
            }
        }
        $this->_fields[$name] = $field;
    }
    
    public function form(){
        
    }
    
    public function get($id){
        $sql = "SELECT * FROM article WHERE id='{$id}'";
        return mydb()->sqlQuery($sql);
    }
    
    
}
