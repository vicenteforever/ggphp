<?php

/**
 * 列表字段
 * @package field
 * @author goodzsq@gmail.com
 */
class field_list extends field_base {
    //@todo goodzsq class field_list not implement
    
    public function validate($value) {
        return true;
    }
    
    public function setting_source($source){
        return $source;
    }
    
    public function hook_list(){
        return array('男', '女');
    }
    
}
