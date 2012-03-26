<?php

return array(
array('name' => 'id', 'label' => 'ID', 'field' => 'id'),
 array('name' => 'inttest', 'label' => '整数测试', 'field' => 'int'),
 array('name' => 'title', 'label' => '标题', 'field' => 'string', 'required' => true),
 array('name' => 'content', 'label' => '正文', 'field' => 'text', 'widget' => 'tinymce'),
 array('name' => 'summary', 'label' => '概要', 'field' => 'text', 'required' => true),
 array('name' => 'radio', 'label' => '单选性别', 'field' => 'list', 'dict' => 'sex', 'widget' => 'radio'),
 array('name' => 'country', 'label' => '国家', 'field' => 'list', 'dict' => 'country', 'required' => true, 'widget' => 'list'),
 array('name' => 'province', 'label' => '地区', 'field' => 'list', 'dict' => 'dict/province', 'widget' => 'level', 'default'=>''),
 array('name' => 'attach', 'label' => '附件', 'field' => 'file', 'settings' => array()),
);
