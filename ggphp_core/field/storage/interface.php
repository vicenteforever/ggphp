<?php

/**
 * 字段存取接口
 * @package field
 * @author $goodzsq@gmail.com
 */
interface field_storage_interface {
    
    public function save($oldData, $newData, $options);
    
    public function load($data, $options);
}