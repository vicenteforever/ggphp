<?php

/**
 * 列表字段
 * @package field
 * @author goodzsq@gmail.com
 */
class field_type_list extends field_type_base {

    public $widgetType = 'list';
     
    public function getList($source) {
        if($source == 'dict'){
            return dict($this->dict)->getData();
        }
        return array();
    }
    
}
