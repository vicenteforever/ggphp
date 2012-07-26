<?php

return array(
    array('name' => 'id', 'label' => 'ID', 'field' => 'serial'),
    array('name' => 'owner', 'label' => '文件所属', 'field' => 'string', 'index'=>true),
    array('name' => 'filename', 'label' => '文件', 'field' => 'string'),
    array('name' => 'name', 'label' => '名称', 'field' => 'string'),
    array('name' => 'ext', 'label' => '扩展名', 'field' => 'string'),
    array('name' => 'mime', 'label' => '数据类型', 'field' => 'string'),
    array('name' => 'size', 'label' => '文件大小', 'field' => 'int'),
    array('name' => 'uploadtime', 'label' => '上传日期', 'field' => 'datetime'),
    array('name' => 'md5', 'label' => 'MD5', 'field' => 'string'),
    array('name' => 'saved', 'label' => '是否保存', 'field' => 'string'),
);
