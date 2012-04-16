<?php

return array(
    array('name' => 'id', 'label' => 'ID', 'field' => 'serial'),
    array('name' => 'inttest', 'label' => '整数测试', 'length' => 4, 'field' => 'int', 'required' => true, 'index' => 'index'),
    array('name' => 'title', 'label' => '标题', 'field' => 'string', 'required' => true, 'length' => 5, 'index' => 'unique'),
    array('name' => 'content', 'label' => '正文', 'field' => 'text', 'widgetStyle' => 'tinymce'),
    array('name' => 'summary', 'label' => '概要', 'field' => 'json', 'required' => false),
    array('name' => 'radio', 'label' => '单选性别', 'field' => 'list', 'dict' => 'sex', 'widgetStyle' => 'radio'),
    array('name' => 'country', 'label' => '国家', 'field' => 'list', 'dict' => 'country', 'required' => true, 'widget' => 'list'),
    array('name' => 'province', 'label' => '地区', 'field' => 'list', 'dict' => 'dict/province', 'widgetStyle' => 'level', 'default' => ''),
    array('name' => 'attach', 'label' => '附件', 'field' => 'file', 'uploadurl' => 'file/upload'),

);
