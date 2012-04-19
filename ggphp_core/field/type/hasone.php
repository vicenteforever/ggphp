<?php

/**
 * 拥有一个所属对象即parent
 * @package field
 * @author goodzsq@gmail.com
 */
class field_type_hasone extends field_type_base {

    public $type = 'string';
    public $length = 255;
    public $source;

    /**
     * 载入关联对象
     * @param string $value
     * @return orm_entity 
     */
    public function load($value) {
        $result = json_decode($value);
        if(!is_object($result)){
            $result = (object)$result;
        }
        return $result;
    }

    public function save($value) {
        return json_encode($value);
    }

}
