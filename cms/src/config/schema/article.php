<?php

return array(
    array('name' => 'id', 'label' => 'ID', 'field' => 'id'),
    array('name' => 'title', 'label' => '标题', 'field' => 'string', 'required' => true),
    array('name' => 'content', 'label' => '正文', 'field' => 'text', 'widget' => 'tinymce'),
    array('name' => 'summary', 'label' => '概要', 'field' => 'text', 'required' => true),
    array('name' => 'radio', 'label' => '单选性别', 'field' => 'list', 'dict'=>'sex', 'widget'=>'radio'),
    array('name' => 'country', 'label' => '国家', 'field' => 'list', 'dict'=>'country', 'required'=>true, 'widget'=>'list'),
    array('name' => 'province', 'label' => '省份', 'field' => 'list', 'dict'=>'dict/province', 'widget'=>'ajaxlist'),
    array('name' => 'test', 'label' => 'test', 'field' => 'list', 'dict'=>'dict/province', 'widget'=>'ajaxlist'),
);
