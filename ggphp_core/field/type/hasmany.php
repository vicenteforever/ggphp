<?php

/**
 * 表示拥有多条记录的字段，例如一篇文章的评论字段对应的多条评论
 * @package field
 * @author goodzsq@gmail.com
 */
class field_type_hasmany extends field_type_base {

    public $type = 'string';
    public $length = 255;
    public $default = '';
    public $table;
    
    /**
     * 载入关联对象
     * @param string $value
     * @return orm_entity 
     */
    public function load($value) {
        $entity = orm($this->table)->query(array());
        return $entity;
    }
    
    public function save($value){
        if(empty($value)){
            return util_string::token();
        }
        else{
            return $value;
        }
    }

}

