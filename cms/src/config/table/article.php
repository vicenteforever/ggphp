<?php

return array(
    array('name' => 'id', 'label' => 'ID', 'field' => 'serial'),
    array('name' => 'title', 'label' => '标题', 'field' => 'string', 'required' => true, 'length' => 5, 'index' => 'unique'),
    array('name' => 'content', 'label' => '正文', 'field' => 'text', 'widgetStyle' => 'tinymce'),
    array('name' => 'attach', 'label' => '附件', 'field' => 'file', 'uploadurl' => 'file/upload'),
    array('name' => 'author', 'label' => '评论', 'field' => 'hasmany', 'source' => 'comment:owner'),
);
