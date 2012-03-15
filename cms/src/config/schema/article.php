<?php

return array(
    array('name' => 'id', 'label' => 'ID', 'field' => 'id'),
    array('name' => 'title', 'label' => '标题', 'field' => 'string', 'required' => true),
    array('name' => 'content', 'label' => '正文', 'field' => 'text', 'widget' => 'tinymce'),
    array('name' => 'summary', 'label' => '概要', 'field' => 'text', 'required' => true),
    array('name' => 'radio', 'label' => 'radio', 'field' => 'text', 'widget'=>'tinymce'),
    array('name' => 'list', 'label' => '性别', 'field' => 'list', 'dict'=>'sex', 'required'=>true, 'widget'=>'radio'),
);
