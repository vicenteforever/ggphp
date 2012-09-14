<?php

/**
 * userfile
 * @package 
 * @author $goodzsq@gmail.com
 */
class field_storage_userfile implements field_storage_interface {

    public function load($data, $options) {
        return rest('userfile')->get($data);
    }

    public function save($oldData, $newData, $options) {
        $options = json_encode($options);
        //修改userfile的owner属性
        if (isset($oldData) && is_array($oldData)) {
            rest('userfile')->put($oldData, array("owner" => ''));
        }
        if (isset($newData) && is_array($newData)) {
            rest('userfile')->put($newData, array("owner" => $options));
        }
    }

    public function delete($data){
        return rest('userfile')->delete($data);
    }
}